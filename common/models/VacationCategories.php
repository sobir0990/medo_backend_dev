<?php

namespace common\models;

use common\modules\categories\models\Categories;
use Yii;

/**
 * This is the model class for table "vacation_categories".
 *
 * @property int $vacation_id
 * @property int $category_id
 *
 * @property Categories $category
 * @property Vacation $vacation
 */
class VacationCategories extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vacation_categories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['vacation_id', 'category_id'], 'required'],
            [['vacation_id', 'category_id'], 'default', 'value' => null],
            [['vacation_id', 'category_id'], 'integer'],
            [['vacation_id', 'category_id'], 'unique', 'targetAttribute' => ['vacation_id', 'category_id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['vacation_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vacation::className(), 'targetAttribute' => ['vacation_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'vacation_id' => 'Vacation ID',
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
    public function getVacation()
    {
        return $this->hasOne(Vacation::className(), ['id' => 'vacation_id']);
    }
}
