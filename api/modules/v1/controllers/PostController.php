<?php

namespace api\modules\v1\controllers;

use api\components\ApiController;
use api\modules\v1\forms\BlogForm;
use api\modules\v1\forms\UpdatePostForms;
use common\models\Post;
use common\models\PostSearch;
//use oks\categories\models\Categories;
use common\components\Categories;
use common\models\User;
use common\modules\category\models\Category;
use common\modules\langs\components\Lang;
use Yii;
use yii\data\ActiveDataFilter;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\UnauthorizedHttpException;

/**
 * @api      {get} /post/:slug Информация пост (View)
 * @apiName  GetPost
 * @apiGroup Post
 *
 * @apiParam {String} slug Post unique slug.
 * @apiSuccess {Number} id ID Post.
 * @apiSuccess {Object} profile Профиль создатител пость
 * @apiSuccess {Object} company Компания создатител поста эсли эсть
 * @apiSuccess {Object} slug Slug пость
 * @apiSuccess {String} title Названия.
 * @apiSuccess {String} description Короткий текст (description).
 * @apiSuccess {String} text Текст.
 * @apiSuccess {Number} view  Сколка посматрения.
 * @apiSuccess {Number} status  Статус 1 актив 0 неактив
 * @apiSuccess {Number} type  NEWS = 1; BLOG = 2; ARTICLE = 3;
 * @apiSuccess {Number} top  Для паказать оделний
 * @apiSuccess {Number} publish_time  Время публикатция.
 * @apiSuccess {Number} created_at  Время создания ответа.
 * @apiSuccess {Number} updated_at  Время  изменения моделя.
 * @apiSuccess {String} files Картинки icon - маленкий w = 50, h =50; small - w=320, h=320; low - w= 40, h=640; normal -
 *  w=1024, h=1024
 * @apiSuccess {String} lang_hash Lang hash  для перовода система
 * @apiSuccess {Number} lang Язык страницу  1 - Uzbek; 2 - Узбек; 3 - Русский; 4 - English.
 *
 * @apiSuccess {Array} categories Категория на пости
 *
 *
 */
/**
 * @api      {get} /post/all-categories Запрос Все категория
 * @apiName  GetAll-categories
 * @apiGroup Post
 *
 * @apiParam {String} all-categories Запрос категория
 *
 * @apiSuccess {Number} id Категория UNIQUE ID.
 * @apiSuccess {String} name Названия
 * @apiSuccess {number} root Древо
 * @apiSuccess {String} slug URL категория
 * @apiSuccess {Number} active Статус 1 - актив; 0 - не актив
 * @apiSuccess {Number} type  Тип 100 - Посты, 200 = Странице, 300 = Направлении
 *
 *
 */

/**
 * @api      {get} /post/category/:slug Запрос категория
 * @apiName  GetCategory
 * @apiGroup Post
 *
 * @apiParam {String} slug Slug категория
 *
 * @apiSuccess {Object} post Посты
 *
 */


/**
 * @api      {post} /post/ Создать блог пость
 * @apiName  CreatePost
 * @apiGroup Post
 *
 * @apiParam {String} title Названия блога
 * @apiParam {String} description Description
 * @apiParam {String} content Контент
 * @apiParam {Number} lang Контент
 * @apiParam {Number} published_time Дата когда публиковать
 * @apiParam {Array} category_id[] Категорий
 * @apiParam {String} image Картинка
 *
 *
 * @apiSuccess {Object} post Блог
 *
 */
class PostController extends ApiController
{

    public $modelClass = Post::class;
    public $searchModelClass = PostSearch::class;

    public function actions()
    {
        $action = parent::actions();
        unset($action['view']);
        unset($action['index']);
        return $action;
    }

    public function actionIndex()
    {
        $requestParams = \Yii::$app->getRequest()->getBodyParams();
        if (empty($requestParams)) {
            $requestParams = \Yii::$app->getRequest()->getQueryParams();
        }

        $query = Post::find();

        $filter = $requestParams['filter'];
        if ($filter['status'] !== null) {
            $query->andWhere(['status' => $filter['status']]);
        }

        if ($filter['type'] !== null) {
            $query->andWhere(['type' => $filter['type']]);
        }

        if ($filter['company_id'] !== null) {
            $query->andWhere(['company_id' => $filter['company_id']]);
        }

        if ($filter['profile_id'] !== null) {
            $query->andWhere(['profile_id' => $filter['profile_id']]);
        }

        if (($tags = Yii::$app->request->getQueryParam('filter')['tags']) !== null) {
            $query->andWhere(['LIKE', 'tags',(string)$tags]);
        }

        $query->andWhere(['lang' => Lang::getLangId()]);

        return new ActiveDataProvider([
            'query' => $query
        ]);
    }


    /**
     * @return ActiveDataProvider
     */
    public function actionArticle()
    {
        $query = Post::find()->where(['type' => Post::TYPE_ARTICLE]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $dataProvider;
    }

    /**
     * @param $slug
     * @return array|Post|\common\models\Posts|null|\yii\db\ActiveRecord
     * @throws NotFoundHttpException
     */
//	public function actionView($slug)
//	{
//	    $post = Post::findOne([$slug => 'slug']);
////		$post = Post::find()->slug($slug)->one();
//		if ($post->status == Post::STATUS_ACTIVE) {
//			$post->updateCounters(['view' => 1]);
//			return $post;
//		} else {
//			$user = User::authorize();
//			if ($post->profile_id == $user->profile->id)
//				return $post;
//			else
//				throw new NotFoundHttpException('Post not found');
//		}
//	}

    /**
     * @throws NotFoundHttpException
     */
    public function actionView($slug)
    {
        return $this->findModelBySlug($slug);
    }

    /**
     * @param $slug
     * @return mixed
     * @throws NotFoundHttpException
     */
    private function findModelBySlug($slug): Post
    {
        $model = Post::findOne(['slug' => $slug]);
        if ($model->status = Post::STATUS_ACTIVE) {
            $model->updateCounters(['view' => 1]);
        }
        if ($model instanceof Post) {
            return $model;
        }
        throw new NotFoundHttpException("Model by slug - $slug not exist");
    }


//    public function actionAllCategories()
//    {
//        if (in_array(\Yii::$app->language, array('oz', 'uz'))) {
//            $category = Categories::find()->where(['type' => 100, 'lang' => Lang::getLangId('uz')]);
//        } else {
//            $category = Categories::find()->where(['type' => 100, 'active' => '1'])->lang();
//        }
//        $data = $category->all();
//        if ($category->count() > 0) {
//            unset($data[0]);
//        }
//        $dataProvider = new ArrayDataProvider([
//            'allModels' => $data,
//        ]);
//        return $dataProvider;
//
//    }


    /**
     * @param $slug
     * @return \yii\data\ActiveDataProvider
     * @throws NotFoundHttpException
     */
    public function actionRelated($slug)
    {
        $model = Post::find()->where(['slug' => $slug])->one();
        if (!$model instanceof Post) {
            throw new NotFoundHttpException('Post not found');
        }

        $post = $model;

        if (!$post instanceof Post) {
            throw new NotFoundHttpException('Post not found');
        }

        $postSearch = new PostSearch();
        $postSearch->detachBehaviors();

        $categories = ArrayHelper::getColumn($post->categories, 'id');

        $postSearch->category = $categories;
        $postSearch->current_post = $post->id;
        $dataProvider = $postSearch->search(\Yii::$app->request->queryParams);
        $dataProvider->query->active();

        return $dataProvider;

    }

    /**
     * @return BlogForm|array
     * @throws UnauthorizedHttpException
     */
    public function actionAdd()
    {
        $model = new BlogForm();
        $model->load($this->requestParams(), '');
        return $model->create();
    }

    /**
     * @param $slug string
     * @return BlogForm|array|Post|null
     * @throws UnauthorizedHttpException
     */
    public function actionUpdate($slug)
    {
        $model = new UpdatePostForms(['slug' => $slug]);
        if ($model->load(\Yii::$app->request->post(), '')) {
            if ($res = $model->update()) {
                return $res;
            }
            return $model->getErrors();
        }
        throw new UnauthorizedHttpException();
    }

    public function actionDeleteSlug($id){
        $model = Post::findOne($id);
        return $model->delete();
    }

}
