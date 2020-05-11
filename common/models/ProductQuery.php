<?php

namespace common\models;

use common\modules\langs\components\QueryBehavior;
use Yii;
use yii\helpers\ArrayHelper;
/**
 * This is the ActiveQuery class for [[Posts]].
 *
 * @see Posts
 */
class ProductQuery extends \yii\db\ActiveQuery
{
	/**
	 * @return array
	 */
	public function behaviors() {
        return [
            'lang' => [
                'class' => QueryBehavior::className(),
                'alias' => Product::tableName()
            ],
        ];
    }

	/**
	 * @return PostQuery
	 */
	public function active()
    {
        return $this->andWhere(['[[product.status]]' => 2]);
    }

    /**
     * @inheritdoc
     * @return Posts[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Posts|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

	/**
	 * @param null $slug
	 * @return $this
	 */
	public function category($slug = null){
        $this->joinWith(['categories']);
        if($slug !== null){
            $this->andFilterWhere(['categories.id' => $slug]);
        }
        return $this;
    }

	/**
	 * @param null $slug
	 * @return $this|bool
	 */
	public function slug($slug = null){
        if($slug == null){return false;}
//        $this->active();
       // $this->lang();
        $this->andWhere(['slug' => $slug]);
        return $this;
    }
    /**
     * @return mixed
     */

}
