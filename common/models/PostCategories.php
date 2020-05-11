<?php

namespace common\models;

use common\components\Categories;
use common\modules\category\models\Category;
use Yii;

/**
 * This is the model class for table "post_categories".
 *
 * @property int        $post_id
 * @property int        $category_id
 *
 * @property Categories $category
 * @property Post       $post
 */
class PostCategories extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'post_categories';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['post_id', 'category_id'], 'required'],
			[['post_id', 'category_id'], 'default', 'value' => null],
			[['post_id', 'category_id'], 'integer'],
			[['post_id', 'category_id'], 'unique', 'targetAttribute' => ['post_id', 'category_id']],
			[['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
			[['post_id'], 'exist', 'skipOnError' => true, 'targetClass' => Post::class, 'targetAttribute' => ['post_id' => 'id']],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'post_id' => 'Post ID',
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
		return $this->hasOne(Post::class, ['id' => 'post_id']);
	}
}
