<?php
/**
 * Created by PhpStorm.
 * User: OKS
 * Date: 11.09.2019
 * Time: 10:45
 */

namespace backend\controllers;


class TestController extends \yii\base\Controller
{
    public $originator = '3700';
    public $baseUrl = 'http://91.204.239.42:8083/broker-api';

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function actionIndex()
    {
        if ($handle = opendir('F:\OSPanel\domains\medo-backend/static/uploads/1W/')) {
            echo "Дескриптор каталога: $handle\n";
            echo "Элементы:\n";

            /* Именно такой способ чтения элементов каталога является правильным. */
            while (false !== ($entry = readdir($handle))) {
                echo "$entry\n";
            }

            /* Это НЕВЕРНЫЙ способ обхода каталога. */
            while ($entry = readdir($handle)) {
                echo "$entry\n";
            }

            closedir($handle);
        }

    }
}