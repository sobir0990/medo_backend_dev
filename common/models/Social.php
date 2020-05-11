<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "social".
 *
 * @property int $id
 * @property string $name
 * @property string $link
 * @property int $company_id
 *
 * @property Company $company
 */
class Social extends \yii\db\ActiveRecord
{
	public static $social = [
		'google', 'facebook', 'twitter', 'vkontakte', 'telegram', 'instagram',
	];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'social';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
        	[['company_id', 'name', 'link'], 'required'],
            [['company_id'], 'default', 'value' => null],
            [['company_id'], 'integer'],
            [['name'], 'string', 'max' => 32],
			['name', 'in', 'range'  => self::$social],
            [['link'], 'string', 'max' => 255],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::class, 'targetAttribute' => ['company_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'link' => 'Link',
            'company_id' => 'Company ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::class, ['id' => 'company_id']);
    }
}
