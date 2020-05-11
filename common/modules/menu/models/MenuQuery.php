<?php

namespace common\modules\menu\models;

use common\modules\langs\components\Lang;
use common\modules\langs\components\QueryBehavior;
use Yii;
use \yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\behaviors\SluggableBehavior;

/**
 * This is the ActiveQuery class for [[Menu]].
 *
 * @see Menu
 */
class MenuQuery extends \yii\db\ActiveQuery
{
    public function behaviors()
    {
        return [
            'lang' => [
                'class' => QueryBehavior::className(),
                'alias' => Menu::tableName()
            ],
        ];
    }

    public function active()
    {
        return $this->andWhere('[[status]]=1');
    }

    /**
     * @inheritdoc
     * @return Menu[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Menu|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }


    public function statuses($status = null)
    {
        if ($status == MenuQuery::STATUS_ACTIVE):
            return Yii::t('main', 'Active');
        else:
            return Yii::t('main', 'Deactive');
        endif;
    }

    public function types()
    {
        $types[] = "Frontend";
        $types[] = "Backend";
        return $types;
    }

    public function lang()
    {
        return $this->andWhere(['lang' => Lang::getLangId()]);
    }
    public function alias($alias = null)
    {
        return $this->andWhere(['alias' => $alias]);
    }
}
