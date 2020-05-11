<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "post_moder".
 *
 * @property int $id
 * @property int $post_id
 * @property int $reason_id
 * @property int $status
 * @property int $created
 *
 * @property ModerReason $reason
 * @property Post $post
 */
class PostModer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post_moder';
    }
    const STATUS_NEW = 0;
    const STATUS_READ = 1;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['post_id', 'reason_id'], 'required'],
            [['post_id', 'reason_id', 'status', 'created'], 'default', 'value' => null],
            [['post_id', 'reason_id', 'status', 'created'], 'integer'],
            [['reason_id'], 'exist', 'skipOnError' => true, 'targetClass' => ModerReason::className(), 'targetAttribute' => ['reason_id' => 'id']],
            [['post_id'], 'exist', 'skipOnError' => true, 'targetClass' => Post::className(), 'targetAttribute' => ['post_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'post_id' => 'Post ID',
            'reason_id' => 'Reason ID',
            'status' => 'Status',
            'created' => 'Created',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReason()
    {
        return $this->hasOne(ModerReason::className(), ['id' => 'reason_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Post::className(), ['id' => 'post_id']);
    }
}
