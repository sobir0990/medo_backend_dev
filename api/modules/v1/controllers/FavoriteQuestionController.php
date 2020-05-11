<?php


namespace api\modules\v1\controllers;


use api\components\ApiController;
use api\modules\v1\forms\QuestionTestForm;
use common\models\FavoriteQuestion;
use common\models\FavoriteQuestionSearch;
use common\models\QuestionCategory;
use common\models\TestQuestion;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

class FavoriteQuestionController extends ApiController
{
    public $modelClass = FavoriteQuestion::class;
    public $searchModelClass = FavoriteQuestionSearch::class;


    public function actionCreate()
    {
        $model = new QuestionTestForm();
        $model->load($this->requestParams(), '');
        return $model->create();
    }

    public function actionCategory()
    {
        $requestParams = \Yii::$app->getRequest()->getBodyParams();
        if (empty($requestParams)) {
            $requestParams = \Yii::$app->getRequest()->getQueryParams();
        }

        $query = QuestionCategory::find();

        if ($requestParams['filter']['category_id'] !== null) {
            $query->andWhere(['category_id' => $requestParams['filter']['category_id']]);
        }
        $ids = ArrayHelper::map($query->all(), 'question_id','question_id');

        $query->andWhere(['IN', 'question_id', array_rand($ids, 5)]);

        return new ActiveDataProvider([
            'query' => $query
        ]);
    }

}
