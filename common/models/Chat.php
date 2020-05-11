<?php

namespace common\models;

/**
 * This is the model class for table "chat".
 *
 * @property int        $id
 * @property string     $title
 * @property int        $company_id
 *
 * @property Company    $company
 * @property Profile[]  $users
 * @property Message[]  $messages
 * @property string     $type   [varchar(32)]
 * @property int     $ext_id
 * @property int     $user_1
 * @property int     $user_2
 */
class Chat extends \yii\db\ActiveRecord
{
    const TYPE_VACATION = 'vacation';
    const TYPE_RESUME = 'resume';
    const TYPE_PRODUCT = 'product';
    const TYPE_ANNOUNCE = 'announce';
    const TYPE_NULL = null;
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'chat';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['company_id'], 'default', 'value' => null],
			[['company_id', 'ext_id', 'user_1','user_2'], 'integer'],
			[['title'], 'string', 'max' => 128],
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
			'title' => 'Name',
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

    public function getUser1()
    {
        return $this->hasOne(Profile::class, ['id' => 'user_1']);
	}

    public function getUser2()
    {
        return $this->hasOne(Profile::class, ['id' => 'user_2']);
	}

    public function getExtLink()
    {
        $rel = null;
        switch ($this->type) {
            case self::TYPE_ANNOUNCE :
                $rel = $this->hasOne(Product::class, ['id' => 'ext_id'])
                    ->onCondition('product.type = '.Product::TYPE_ANNOUNCE);
                break;
            case self::TYPE_PRODUCT :
                $rel = $this->hasOne(Product::class, ['id' => 'ext_id'])
                    ->onCondition('product.type = '.Product::TYPE_PRODUCT);
                break;
            case self::TYPE_RESUME :
                $rel = $this->hasOne(Resume::class, ['id' => 'ext_id']);
                break;
            case self::TYPE_VACATION :
                $rel = $this->hasOne(Vacation::class, ['id' => 'ext_id']);
                break;
            case self::TYPE_NULL :
            default :
                $rel = null;
                break;
        }
        return $rel;
	}
	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getMessages()
	{
		return $this->hasMany(Message::className(), ['chat_id' => 'id']);
	}

    public function getMsgCount($id)
    {
        return self::find()->joinWith('messages')->andWhere(['chat.id' => $id])->count('message.id');
	}

	public function getUnreadCount($id)
    {
        return self::find()->joinWith('messages')->andWhere(['chat.id' => $id, 'message.is_read' => 0])->count();
    }

	public function fields()
	{
		return [
		    'id',
            'title',
            'company',
            'type',
            'extLink',
            'count' => function() {
                return $this->getMsgCount($this->id);
            },
            'unread' => function() {
		        return $this->getUnreadCount($this->id);
            },
            'user1',
            'user2',
			'messages'=> function(){
		    return $this->getMessages();
            },
		];
	}
}
