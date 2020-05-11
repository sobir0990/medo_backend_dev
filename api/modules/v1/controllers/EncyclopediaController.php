<?php

namespace api\modules\v1\controllers;

use api\components\ApiController;
use common\models\Encyclopedia;
use common\models\EncyclopediaCategories;
use common\models\EncyclopediaSearch;
use common\components\Categories;
use common\modules\category\models\Category;
use common\modules\langs\components\Lang;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

class EncyclopediaController extends ApiController
{

    public $modelClass = Encyclopedia::class;
    public $searchModelClass = EncyclopediaSearch::class;

    public function actions()
    {
        $action = parent::actions();

        unset($action['index']);
        unset($action['view']);
        return $action;

    }

    public function actionIndex()
    {
        $requestParams = $this->requestParams();

        $model = Encyclopedia::find();

        if ($requestParams['filter']['title'] !== null) {
            $model->andWhere(['ilike', 'title',$requestParams['filter']['title']]);
        }

        if ($requestParams['filter']['category_id'] !== null) {
            $model->leftJoin('encyclopedia_categories', '"encyclopedia".id = "encyclopedia_categories".encyclopedia_id');
            $model->andWhere(['encyclopedia_categories.category_id' => $requestParams['filter']['category_id']]);
        }

        if (($letter = \Yii::$app->request->getQueryParam('filter')['letter']) !== null) {
            $model->andWhere(['letter' => $letter]);
        }

        return new ActiveDataProvider([
            'query' => $model
        ]);
    }

    public function actionCategories()
    {
        $encyclopedia = Encyclopedia::find()
            ->select(['COUNT(encyclopedia.*)', 'category.id', 'category.name'])
            ->joinWith('categoryOrNew')
            ->groupBy('category.id')
            ->orderBy('count DESC')
            ->asArray()
            ->all();
        return $encyclopedia;
    }

    public function actionCategoryList()
    {
        $category = Category::find()
            ->andWhere(['status' => Category::STATUS_ACTIVE])
            ->andWhere(['type' => 'Encyclopedia'])
            ->all();
        return $category;
    }

    /**
     * @param $slug
     * @return ActiveDataProvider
     * @throws NotFoundHttpException
     */
    public function actionCategory($id)
    {
        $category = EncyclopediaCategories::find()->andWhere(['category_id' => $id])->one();

        if (!$category instanceof EncyclopediaCategories) {
            throw new NotFoundHttpException("Category not found");
        }

        $query = Encyclopedia::find()->andWhere(['encyclopedia.id' => $category->category_id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $dataProvider;
    }

    public function actionView($slug)
    {
        $model = Encyclopedia::findOne(['encyclopedia.slug' => $slug]);
        if ($model) return $model;
        else throw new NotFoundHttpException();
    }

    public function actionLetter($letter)
    {
        $query = Encyclopedia::find()->where(['letter' => $letter, /*'status' => Encyclopedia::STATUS_PUBLISHED*/]);
        return $this->getFilteredData($query, $this->searchModelClass);
    }
}
