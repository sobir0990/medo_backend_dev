<?php

namespace common\modules\paycom\models\query;

/**
 * This is the ActiveQuery class for [[\common\modules\paycom\models\PaymentHistory]].
 *
 * @see \common\modules\paycom\models\PaymentHistory
 */
class PaymentHistoryQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\modules\paycom\models\PaymentHistory[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\modules\paycom\models\PaymentHistory|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
