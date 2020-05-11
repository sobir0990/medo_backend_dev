<?php
/**
 * Created by PhpStorm.
 * User: izzat
 * Date: 09.08.18
 * Time: 14:45
 */

namespace common\behaviors;


use yii\base\Behavior;

class TranslationBehavior extends Behavior {

    public $table;

    public function translation($hash) {
        return $this->owner->leftJoin("translations", "translations.hash = {$this->table}.name_hash")
            ->andWhere(['translations.message'=>$hash]);

    }

    public function lang() {
        return $this->owner->select("{$this->table}.*, translations.message as name_hash")
            ->leftJoin("translations", "translations.hash = {$this->table}.name_hash")
            ->andWhere(['translations.language' => \Yii::$app->language]);
    }

}