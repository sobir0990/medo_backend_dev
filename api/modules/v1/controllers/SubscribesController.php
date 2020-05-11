<?php


namespace api\modules\v1\controllers;


use api\components\ApiController;
use common\models\Subscribes;
use common\models\SubscribesSearch;

class SubscribesController extends ApiController
{
    public $modelClass = Subscribes::class;
    public $searchModelClass = SubscribesSearch::class;

}
