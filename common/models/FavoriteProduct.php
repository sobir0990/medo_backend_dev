<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "favorite_product".
 *
 * @property int $profile_id
 * @property int $product_id
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Product $product
 * @property Profile $profile
 */
class FavoriteProduct extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'favorite_product';
    }

    public function behaviors()
    {
     return [
         TimestampBehavior::class
     ];
    }

    public function extraFields()
    {
        return array_merge(parent::extraFields(), [
            'product',
            'profile'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['profile_id', 'product_id'], 'required'],
            [['profile_id', 'product_id', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['profile_id', 'product_id', 'created_at', 'updated_at'], 'integer'],
            [['profile_id', 'product_id'], 'unique', 'targetAttribute' => ['profile_id', 'product_id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
            [['profile_id'], 'exist', 'skipOnError' => true, 'targetClass' => Profile::className(), 'targetAttribute' => ['profile_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'profile_id' => 'Profile ID',
            'product_id' => 'Product ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['id' => 'profile_id']);
    }
}
