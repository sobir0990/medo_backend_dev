<?php

namespace common\models;

use common\modules\category\models\Category;
use Yii;

/**
 * This is the model class for table "post_categories".
 *
 * @property int        $encyclopedia_id
 * @property int        $category_id
 *
 * @property Category $category
 * @property Encyclopedia  $encyclopedia
 */
class EncyclopediaCategories extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'encyclopedia_categories';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['encyclopedia_id', 'category_id'], 'required'],
			[['encyclopedia_id', 'category_id'], 'default', 'value' => null],
			[['encyclopedia_id', 'category_id'], 'integer'],
			[['encyclopedia_id', 'category_id'], 'unique', 'targetAttribute' => ['encyclopedia_id', 'category_id']],
			[['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
			[['encyclopedia_id'], 'exist', 'skipOnError' => true, 'targetClass' => Encyclopedia::class, 'targetAttribute' => ['encyclopedia_id' => 'id']],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'encyclopedia_id' => 'Encyclopedia ID',
			'category_id' => 'Category ID',
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getCategory()
	{
		return $this->hasOne(Category::class, ['id' => 'category_id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getPost()
	{
		return $this->hasOne(Encyclopedia::class, ['id' => 'encyclopedia_id']);
	}
}
