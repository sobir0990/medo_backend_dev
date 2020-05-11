<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "message".
 *
 * @property int     $id
 * @property string  $message
 * @property int     $from_user
 * @property int     $chat_id
 * @property int     $created_at
 * @property int     $updated_at
 * @property int     $is_read
 *
 * @property Profile $fromUser
 * @property Chat    $chat
 */
class Message extends \yii\db\ActiveRecord
{
	public function behaviors()
	{
		return array_merge(parent::behaviors(), [
			TimestampBehavior::class,
		]);
	}

	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'message';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['message', 'chat_id'], 'required'],
			[['from_user', 'chat_id', 'created_at', 'updated_at'], 'integer'],
			[['message'], 'string', 'max' => 255],
			[['from_user'], 'exist', 'skipOnError' => true, 'targetClass' => Profile::class, 'targetAttribute' => ['from_user' => 'id']],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'message' => 'Message',
			'from_user' => 'From User',
			'reply_to' => 'Reply To',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
		];
	}

	public function getChat()
	{
		return $this->hasOne(Chat::class, ['id' => 'chat_id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getFromUser()
	{
		return $this->hasOne(Profile::class, ['id' => 'from_user']);
	}

    public function extraFields()
    {
        return [
            'user' => function() {
                return $this->fromUser;
            },
        ];
	}
}
