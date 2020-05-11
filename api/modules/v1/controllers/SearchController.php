<?php
/**
 * User: jamwid07
 * Date: 31/01/19
 */

namespace api\modules\v1\controllers;


use api\components\ApiController;
use common\models\Company;
use common\models\CompanySearch;
use common\models\Encyclopedia;
use common\models\EncyclopediaSearch;
use common\models\Post;
use common\models\PostSearch;
use common\models\Product;
use common\models\ProductSearch;
use common\models\Resume;
use common\models\ResumeSearch;
use common\models\Vacation;
use common\models\VacationSearch;
use Yii;

class SearchController extends ApiController
{
	public function actions()
	{
		$act = parent::actions();
		unset($act['index']);
		return $act;
	}

	public function actionIndex($q)
	{
        $requestParams = Yii::$app->request->getQueryParams();
        if ($requestParams == null) {
            $requestParams = Yii::$app->request->getBodyParams();
        }

		$product = Product::find()->orWhere(['ilike', 'title', $q])->orWhere(['ilike', 'content', $q])->limit(3)->all();
		$resume = Resume::find()->orWhere(['ilike', 'title', $q])->orWhere(['ilike', 'text', $q])->limit(3)->all();
		$vacation = Vacation::find()->orWhere(['ilike', 'title', $q])->orWhere(['ilike', 'text', $q])->limit(3)->all();
		$company = Company::find()->orWhere(['ilike', 'company.name', $q])->orWhere(['ilike', 'description', $q])->limit(3)->all();
		$post = Post::find()->orWhere(['ilike', 'title', $q])->orWhere(['ilike', 'description', $q])->orWhere(['ilike', 'text', $q])->limit(3)->all();

		$response = [
			'product' => $product,
			'resume' => $resume,
			'vacation' => $vacation,
			'company' => $company,
			'post' => $post,
		];
		return $response;
	}

	/**
	 * @param $q string Request query for search
	 * @return \yii\data\ActiveDataProvider
	 */
	public function actionProduct($q)
	{
		$query = Product::find()->orFilterWhere(['ilike', 'name_' . Yii::$app->language, $q])->orFilterWhere(['ilike', 'content_' .Yii::$app->language, $q]);

        if (($status = Yii::$app->request->getQueryParam('filter')['status']) !== null) {
            $query->andWhere(['"product".status' => $status]);
        }
		return $this->getFilteredData($query, ProductSearch::class);
	}

	public function actionResume($q)
	{
		$query = Resume::find()->orFilterWhere(['ilike', 'title', $q])->orFilterWhere(['ilike', 'text', $q]);

        if (($category_id = Yii::$app->request->getQueryParam('filter')['category_id']) !== null){
            $query->leftJoin('resume_categories', '"resume".id = "resume_categories".resume_id');
//            $categories = @ArrayHelper::map(Categories::findOne($category_id)->getTranslation(false),'id','id');
//            throw new \DomainException(json_encode($categories));
//            $query->leftJoin('categories', '"resume_categories".category_id = "categories".id');
            $query->andWhere(['"resume_categories".category_id' => $category_id]);
        }

        if (($status = Yii::$app->request->getQueryParam('filter')['status']) !== null) {
            $query->andWhere(['"resume".status' => $status]);
        }

		return $this->getFilteredData($query, ResumeSearch::class);
	}

	public function actionVacation($q)
	{
		$query = Vacation::find()->orFilterWhere(['ilike', 'title', $q])->orFilterWhere(['ilike', 'text', $q]);

        if (($status = Yii::$app->request->getQueryParam('filter')['status']) !== null) {
            $query->andWhere(['"vacation".status' => $status]);
        }

		return $this->getFilteredData($query, VacationSearch::class);
	}

	public function actionCompany($q)
	{
        $requestParams = Yii::$app->request->getQueryParams();
        if (empty($requestParams)) {
            $requestParams = Yii::$app->request->getBodyParams();
        }

	    $lang = \Yii::$app->language;
		$query = Company::find()->orFilterWhere(['ilike', 'company.name_'.$lang, $q])->orFilterWhere(['ilike', 'description_'.$lang, $q]);

        if (($category_id = Yii::$app->request->getQueryParam('filter')['category_id']) !== null){
//            $query->leftJoin('company_categories', '"company".id = "company_categories".company_id');
            $query->andWhere(['"company_categories".category_id' => $category_id]);
        }

        if (($status = Yii::$app->request->getQueryParam('filter')['status']) !== null) {
            $query->andWhere(['"company".status' => $status]);
        }

        if ($requestParams['filter']['types'] !== null) {
            if ($requestParams['filter']['types'] == 1) {
                $query->andWhere(['"company".type' => [Company::TYPE_MAINTAINER, Company::TYPE_PROVIDER]]);
            } elseif ($requestParams['filter']['types'] == 2) {
                $query->andWhere(['"company".type' => [Company::TYPE_MED_INSTITUTE, Company::TYPE_MED_SCHOOL]]);
            }
        }

		return $this->getFilteredData($query, CompanySearch::class);
	}

	public function actionPost($q)
	{
		$query = Post::find()->orFilterWhere(['ilike', 'title', $q])->orFilterWhere(['ilike', 'description', $q])->orFilterWhere(['ilike', 'text', $q]);

        if (($status = Yii::$app->request->getQueryParam('filter')['status']) !== null) {
            $query->andWhere(['"post".status' => $status]);
        }

		return $this->getFilteredData($query, PostSearch::class);
	}

	public function actionEncyclopedia($q)
	{

		$query = Encyclopedia::find()->orFilterWhere(['ilike', 'title', $q])->orFilterWhere(['ilike', 'description', $q])->orFilterWhere(['ilike', 'text', $q]);
        if (($category_id = Yii::$app->request->getQueryParam('filter')['category_id']) !== null){
            $query->andWhere(['"encyclopedia_categories".category_id' => $category_id]);
        }

        if (($status = Yii::$app->request->getQueryParam('filter')['status']) !== null) {
            $query->andWhere(['"encyclopedia".status' => $status]);
        }

		return $this->getFilteredData($query, EncyclopediaSearch::class);
	}
}
