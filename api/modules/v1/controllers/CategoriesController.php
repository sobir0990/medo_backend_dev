<?php


namespace api\modules\v1\controllers;


use api\components\ApiController;
use common\modules\category\models\Category;
use common\modules\category\models\CategorySearch;
use Yii;
use yii\data\ActiveDataProvider;

class CategoriesController extends ApiController
{
    public $modelClass = Category::class;
    public $searchModelClass = CategorySearch::class;


    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index']);
        return $actions;
    }

    public function actionIndex()
    {
        $requestParams = Yii::$app->request->getQueryParams();
        if ($requestParams == null) {
            $requestParams = Yii::$app->request->getBodyParams();
        }

        $query = Category::find();



        if (($name = Yii::$app->request->getQueryParam('filter')['name']) !== null) {
            $query->andWhere(['ILIKE', 'name', (string)$name]);
        }

        return new ActiveDataProvider([
            'query' => $query
        ]);
    }

}
