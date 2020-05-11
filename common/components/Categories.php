<?php

namespace common\components;

use common\models\ProductCategories;

class Categories extends \common\modules\categories\models\Categories
{
    public function fields()
    {
        return array(
            'id',
            'name',
            'root',
            'slug',
            'active',
            'type',
            'childs',
            'icon',
            'icon' => function () {
                if (empty($this->icon)) {
                    return getenv('STATIC_URL') . 'icons/' . $this->icon;
                }
            }
        );
    }

    public function afterFind()
    {
        if (\Yii::$app->language == 'oz') {
            $this->name = \Yii::$app->utils->translateToLatin($this->name);
        }
    }

    public function getChilds()
    {
        if ($child = self::find()->childrensById($this->id))
            return $child;
        else return [];
    }

    public function getProductCategories()
    {
        return $this->hasMany(ProductCategories::class, ['category_id' => 'id']);
    }

    /**
     * @param int|null $lang
     * @return array|\common\modules\categories\models\Category|\common\modules\categories\models\Category[]|mixed
     */
    public function getTranslation($withoutMe = true,int $lang = null)
    {
	    $translations = static::find()
            ->andWhere(['lang_hash' => $this->lang_hash]);
	    if($withoutMe){
            $translations->andWhere(['<>','lang',$this->lang]);
        }

	    $translations = $translations->indexBy('lang')->all();

	    if($lang !== null){
	        return $translations[$lang];
        }

	    return $translations;
    }
}