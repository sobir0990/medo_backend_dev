<?php

namespace common\modules\category\modules\admin\controllers;


use common\modules\category\models\Category;
use common\modules\category\models\CategorySearch;
use yii\rest\Controller;


/**
* This is the class for REST controller "ApiCategoryController".
*/

class ApiCategoryController extends Controller
{


    public $modelClass = Category::class;
    public $searchModelClass = CategorySearch::class;





}
