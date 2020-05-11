<?php

namespace common\models;

use common\modules\categories\models\Categories;
use Yii;

/**
 * This is the model class for table "profile_categories".
 *
 * @property int $profile_id
 * @property int $category_id
 *
 * @property Categories $category
 * @property Profile $profile
 */
class ProfileCategories extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profile_categories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['profile_id', 'category_id'], 'required'],
            [['profile_id', 'category_id'], 'default', 'value' => null],
            [['profile_id', 'category_id'], 'integer'],
            [['profile_id', 'category_id'], 'unique', 'targetAttribute' => ['profile_id', 'category_id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['category_id' => 'id']],
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
            'category_id' => 'Category ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Categories::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['id' => 'profile_id']);
    }
}
