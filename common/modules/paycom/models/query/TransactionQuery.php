<?php

namespace common\modules\paycom\models\query;

/**
 * This is the ActiveQuery class for [[\common\modules\paycom\models\Transaction]].
 *
 * @see \common\modules\paycom\models\Transaction
 */
class TransactionQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\modules\paycom\models\Transaction[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\modules\paycom\models\Transaction|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
