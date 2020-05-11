<?php

namespace common\modules\menu\modules\admin\controllers;

use common\modules\menu\models\MenuItems;
use Yii;
use common\modules\menu\models\Menu;
use common\modules\menu\models\MenuSearch;
use yii\caching\TagDependency;
use yii\db\Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * MenuController implements the CRUD actions for Menu model.
 */
class MenuController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Menu models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MenuSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Menu model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Menu model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Menu();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \yii\caching\TagDependency::invalidate(Yii::$app->cache,['menu']);
            return $this->redirect(['update', 'id' => $model->menu_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Menu model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        \yii\caching\TagDependency::invalidate(Yii::$app->cache,'menu');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
        }

        $menuItem = new MenuItems(['menu_id' => $model->menu_id]);
        if(Yii::$app->request->post('MenuItems'))
        {
            $info = Yii::$app->request->post('MenuItems');
            if(!array_key_exists('menu_item_id', $info)){
                if($menuItem->load(Yii::$app->request->post())){
                    $menuItem->save();
                }
            }else{
                $data = MenuItems::findOne($info['menu_item_id']);
                $data->title = $info['title'];
                $data->url = $info['url'];
                $data->icon = $info['icon'];
                $data->save();
            }
        }
        if(Yii::$app->request->isAjax){
            if(Yii::$app->request->post('menuItemUpdate')){
                $id = Yii::$app->request->post('id');
                $parent = Yii::$app->request->post('parent');
                $sort = Yii::$app->request->post('sort');
                if(!preg_match('#[0-9]+#',$parent)){
                    $parent = NULL;
                }
                $data['id'] = $id;
                $data['parent'] = $parent;
                $data['sort'] = $sort;
                Yii::$app->response->format = Response::FORMAT_JSON;

                $item = MenuItems::findOne($id);
                $item->menu_item_parent_id = $parent;
                $item->sort = $sort;
                $item->save();
                return $item->getErrors();
            }
        }

        return $this->render('update', [
            'model' => $model,
            'menuItem' => $menuItem
        ]);
    }

    /**
     * Deletes an existing Menu model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        \yii\caching\TagDependency::invalidate(Yii::$app->cache,'menu');
        return $this->redirect(['index']);
    }

    /**
     * Finds the Menu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Menu the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Menu::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actions(){
        return [
            'getdata' => [
                'class' => 'jakharbek\datamanager\actions\Action',
                'table' => 'menu',
                'primaryColumn' => 'menu_id',
                'textColumn' => 'title'
            ],
        ];
    }
    public function actionDeleteItem(){
        try{

            $id = Yii::$app->request->post('id');
            if(MenuItems::findOne($id)->delete()){
                \yii\caching\TagDependency::invalidate(Yii::$app->cache,'menu');
                return 'ok';
            }

        }
        catch(Exception $e){
            return "error";
        }
    }


}
