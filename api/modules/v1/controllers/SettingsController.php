<?php

namespace api\modules\v1\controllers;

use api\components\ApiController;
use common\modules\settings\models\Settings;
use common\modules\settings\models\SettingsSearch;

class SettingsController extends ApiController
{
    public $modelClass = Settings::class;
    public $searchModelClass = SettingsSearch::class;

    public function actionContact()
    {
        $facebook = Settings::value('facebook-social');
        $google = Settings::value('google-plus');
        $twitter = Settings::value('twitter-social');
        $telegram = Settings::value('telegram-social');
        $instagram = Settings::value('instagram');

        return [
            'facebook' => $facebook,
            'google' => $google,
            'twitter' => $twitter,
            'telegram' => $telegram,
            'instagram' => $instagram,
        ];
    }

    public function actionGetValue()
    {
        if ($slug = \Yii::$app->request->getQueryParam('slug')) {
            return Settings::value($slug);
        }
    }
}
