<?php
/**
 * Created by PhpStorm.
 * User: Asus ONE
 * Date: 21.11.2018
 * Time: 16:34
 */

namespace api\components;


use common\filemanager\models\Files;
use yii\data\ActiveDataFilter;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecordInterface;
use yii\filters\ContentNegotiator;
use yii\filters\RateLimiter;
use yii\helpers\ArrayHelper;
use yii\rest\Controller;
use yii\rest\OptionsAction;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;

abstract class ApiController extends Controller
{
	public $modelClass;
	public $searchModelClass;

	private $requestParams;

	public $serializer = [
		'class' => '\yii\rest\Serializer',
		'collectionEnvelope' => 'data',
		'expandParam' => 'include'
	];

	public function behaviors()
	{
		return ArrayHelper::merge(parent::behaviors(), [
			'contentNegotiator' => [
				'class' => ContentNegotiator::class,
				'formats' => [
					'application/json' => Response::FORMAT_JSON,
					'application/xml' => Response::FORMAT_XML,
				],
				'languages' => array(
					'oz',
					'uz',
					'ru'
				),
				'formatParam' => '_f',
				'languageParam' => '_l',
			],
			'rateLimiter' => [
				'class' => RateLimiter::class,
			],
		]);
	}

	public function actions()
	{
		return [
			'index' => [
				'class' => 'yii\rest\IndexAction',
				'modelClass' => $this->modelClass,
				'dataFilter' => [
					'class' => 'yii\data\ActiveDataFilter',
					'searchModel' => $this->searchModelClass,
				]

			],
			'view' => [
				'class' => 'yii\rest\ViewAction',
				'modelClass' => $this->modelClass,
			],
			'options' => [
				'class' => OptionsAction::class,
			]
		];
	}

	/**
	 * @param $id
	 * @return mixed
	 * @throws NotFoundHttpException
	 */
	public function findModel($id)
	{
		/* @var $modelClass ActiveRecordInterface */
		$modelClass = $this->modelClass;
		$keys = $modelClass::primaryKey();
		if (count($keys) > 1) {
			$values = explode(',', $id);
			if (count($keys) === count($values)) {
				$model = $modelClass::findOne(array_combine($keys, $values));
			}
		} elseif ($id !== null) {
			$model = $modelClass::findOne($id);
		}

		if (isset($model)) {
			return $model;
		}

		throw new NotFoundHttpException("Object not found: $id");
	}

	/**
	 * @return mixed
	 * @throws \yii\base\InvalidConfigException
	 */
	public function getRequestParams()
	{
		$this->requestParams = \Yii::$app->getRequest()->getBodyParams();
		if (empty($requestParams)) {
			$this->requestParams = \Yii::$app->getRequest()->getQueryParams();
		}

		return $this->requestParams;
	}

	public function getFilteredData($query, $searchModel)
	{
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		$filter = null;
		$dataFilter = new ActiveDataFilter();
		$dataFilter->searchModel = $searchModel;

		if ($dataFilter->load($this->getRequestParams())) {
			$filter = $dataFilter->build();
		}

		if (!empty($filter)) {
			$dataProvider->query->andWhere($filter);
		}

		return $dataProvider;

	}

    /**
     * @param $attribute
     * @param $user_id
     * @return Files[]|bool
     */
    public function saveFiles($attribute, $user_id)
    {
        $res = null;
        $files = UploadedFile::getInstancesByName($attribute);
        if (count($files)) {
            foreach ($files as $file) {
                $model = new Files();
                $model->file_data = $file;
                $model->user_id = $user_id;
                if ($model->save()) {
                    $res .= $model->file_id.',';
                } else {
                    return false;
                }
            }
        }
        return $res;
	}

    public function requestParams()
    {
        $requestParams = \Yii::$app->request->getBodyParams();
        if (empty($requestParams)) {
            $requestParams = \Yii::$app->request->getQueryParams();
        }
        return $requestParams;
    }
}