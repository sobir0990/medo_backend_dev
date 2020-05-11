<?php


namespace api\modules\v1\controllers;


use api\components\ApiController;
use common\models\Banner;
use common\models\BannerSearch;

class BannerController extends ApiController
{
    public $modelClass = Banner::class;
    public $searchModelClass = BannerSearch::class;

    public function actionBySlug()
    {
        $slug = \Yii::$app->request->getQueryParams('slug');
        $pages = Banner::find()->andWhere(['slug' => $slug])->one();
        return $pages;
    }


}
