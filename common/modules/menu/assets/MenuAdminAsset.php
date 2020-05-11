<?php
/**
 * Created by PhpStorm.
 * User: utkir
 * Date: 13.08.2018
 * Time: 15:05
 */

namespace common\modules\menu\assets;


use yii\web\AssetBundle;

class MenuAdminAsset extends AssetBundle
{
    public $sourcePath = '@common/modules/menu/assets/web/';

    public $js = [
//        'js/menu-admin.js',
        'js/jquery-sortable.js',
        'js/query-js.js'
    ];

    public $css = [
      'css/menu-admin.css'
    ];
    public $jsOptions = ['position' => \yii\web\View::POS_END];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}