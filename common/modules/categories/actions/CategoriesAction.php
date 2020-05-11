<?php
namespace common\modules\categories\actions;

use Yii;
use yii\base\Action;

class CategoriesAction extends Action{

    public function run(){

        return $this->controller->render('@common/modules/categories/views/categories');
    }

}