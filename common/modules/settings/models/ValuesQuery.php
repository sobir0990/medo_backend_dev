<?php

namespace common\modules\settings\models;

use common\modules\langs\components\QueryBehavior;
use Yii;
use \yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\behaviors\SluggableBehavior;
/**
 * This is the ActiveQuery class for [[Values]].
 *
 * @see Values
 */
class ValuesQuery extends \yii\db\ActiveQuery
{
    public function behaviors() {
        return [
            QueryBehavior::className()
        ];
    }
    public function active()
    {
        return $this->andWhere('[[status]]=1');
    }

    /**
     * @inheritdoc
     * @return Values[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Values|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }


    public function statuses($status = null){
        if($status == ValuesQuery::STATUS_ACTIVE):
            return Yii::t('main','Active');
        else:
            return Yii::t('main','Deactive');
        endif;
    }
}
