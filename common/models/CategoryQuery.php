<?php
namespace common\models;

use common\modules\category\models\Category;

/**
 * This is the ActiveQuery class for [[common\modules\category\models\Category]].
 *
 * @see \common\models\Event
 */
class CategoryQuery extends \yii\db\ActiveQuery
{
    /**
     * @param null $db
     * @return array|\yii\db\ActiveRecord[]
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @param null $db
     * @return array|\yii\db\ActiveRecord|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

}
