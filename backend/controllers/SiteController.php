<?php
namespace backend\controllers;

use common\models\City;
use common\models\Region;
use common\models\User;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\LoginForm;
use yii\web\Response;
use yii\data\Pagination;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actionError() {

        $exeption = \Yii::$app->errorHandler->exception;
        $code = $exeption->statusCode;
        $name = $exeption->getName();
        $message = $exeption->getMessage();

        \Yii::$app->layout = 'error_layout';
        return $this->render('error', [
            'code' => $code,
            'name' => $name,
            'message' => $message
        ]);
    }


    /**
     * @return string
     */
    public function actionIndex(){
        $user = User::find()->orderBy("created_at DESC");
        $pages = new Pagination(['totalCount'=>$user->count(),'pageSize' => 8,'pageSizeParam'=>false,'forcePageParam'=>false]);
        $user = $user->offset($pages->offset)->limit($pages->limit)->all();

        return $this->render('index', ['user' => $user, 'pages' => $pages]);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        Yii::$app->layout = 'no_carcas';
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->login()) {
                return $this->redirect(\Yii::$app->request->referrer);
            }
            else {
                return $this->render('login', [
                    'model' => $model,
                ]);
            }
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionCity($id) {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->isAjax) {
            $cities = City::find()->select(['id', 'name'])->where(['region_id' => $id])->all();
            return ['success' => true, 'cities' => $cities];
        }

        return ['oh no' => 'you are not allowed :('];
    }
}
