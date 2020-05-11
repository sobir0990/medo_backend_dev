<?php
/**
 * Created by PhpStorm.
 * User: izzat
 * Date: 09.08.18
 * Time: 14:45
 */

namespace common\behaviors;


use common\modules\translations\models\Translations;
use yii\base\Behavior;
use yii\caching\TagDependency;
use yii\db\ActiveRecord;

class MultilanguageTranslationsBehavior extends Behavior {

    public $hash_attribute = 'name_hash';
    public $message_attribute = 'multi_name';

    public function events()
    {
        return array(
            ActiveRecord::EVENT_AFTER_FIND => 'getTranslations',
            ActiveRecord::EVENT_BEFORE_INSERT => 'setTranslations',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'setTranslations',
        );
    }

    public function getTranslations() {

        $cache_key = "translations_hash_{$this->owner->{$this->hash_attribute}}";

        $translations = \Yii::$app->cache->get($cache_key);

        if ($translations === false) {
            $translations = Translations::find()->where(['translations.hash'=>$this->owner->{$this->hash_attribute}])->all();
            \Yii::$app->cache->set($cache_key, $translations, 300);
        }


        $messages = array();

        foreach($translations as $translation) {
            $messages[$translation->language] = $translation->message;
        }


        $this->owner->{$this->message_attribute} = $messages;

    }

    public function setTranslations() {
        $messages = $this->owner->{$this->message_attribute};

        if(\Yii::$app->controller->id != "synchronize") {
            foreach($messages as $language => $message) {
                if (empty($message)) {
                    continue;
                }

                $translation = Translations::findOne(['translations.hash'=>$this->owner->{$this->hash_attribute}, 'language' => $language]);
                if (!$translation instanceof Translations) {
                    $translation = new Translations();
                }
                $translation->hash = $this->owner->{$this->hash_attribute};
                $translation->language = $language;
                $translation->message = $message;
                $translation->save();
                if(is_null($this->owner->{$this->hash_attribute})) {
                    $this->owner->{$this->hash_attribute} = $translation->hash;
                }
            }
        }

    }

    public function getNameHash()
    {
        $query = Translations::find()->where(['hash' => $this->owner->name_hash, 'language' => \Yii::$app->language]);
        $count = $query->count();
        return $count > 0 ? $query->one() : $this->owner->hasOne(Translations::className(), ['hash' => 'name_hash']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCommonName()
    {
        $query = Translations::find()->where(['hash' => $this->owner->name_hash, 'language' => \Yii::$app->language]);
        $count = $query->count();
        return $count > 0 ? $query->one() : $this->owner->hasOne(Translations::className(), ['hash' => 'common_name']);
    }



}