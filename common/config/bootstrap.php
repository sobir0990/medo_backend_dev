<?php
Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@api', dirname(dirname(__DIR__)) . '/api');
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@static', dirname(dirname(__DIR__)) . '/static');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');
function __($message, $params = array())
{
    return Yii::t('main', $message, $params, Yii::$app->language);
}

function _url($url = '', $scheme = false)
{
    return \yii\helpers\Url::to($url, $scheme);
}

$container = \Yii::$app->container;
