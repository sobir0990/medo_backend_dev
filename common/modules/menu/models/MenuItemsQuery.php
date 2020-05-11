<?php

namespace common\modules\menu\models;

use Yii;
use \yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\behaviors\SluggableBehavior;
/**
 * This is the ActiveQuery class for [[MenuItems]].
 *
 * @see MenuItems
 */
class MenuItemsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return MenuItems[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return MenuItems|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }


    public function statuses($status = null){
        if($status == MenuItemsQuery::STATUS_ACTIVE):
            return Yii::t('main','Active');
        else:
            return Yii::t('main','Deactive');
        endif;
    }
}
