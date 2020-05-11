<?php
/**
 * @author Izzat <i.rakhmatov@list.ru>
 * @package advanced
 */

namespace common\modules\paycom;


use common\modules\paycom\models\Response;

class Module extends \yii\base\Module {

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'common\modules\paycom\controllers';

    /**
     * @inheritdoc
     */
    public function init() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        parent::init();
    }

}