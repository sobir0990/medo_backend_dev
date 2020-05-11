<?php

namespace common\modules\menu\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class MenuAssets extends AssetBundle
{
    public $sourcePath = '@common/modules/menu/assets/web/';

    public $js = [
        'jquery-sortable.js',
        'query-js.js'
    ];

    public $jsOptions = ['position' => \yii\web\View::POS_END];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
