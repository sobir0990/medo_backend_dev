<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "review".
 *
 * @property int $id
 * @property int $profile_id
 * @property int $product_id
 * @property int $company_id
 * @property string $text
 * @property int  $type
 * @property int  $reply_to
 * @property int  $rating
 * @property int  $status
 * @property int  $created_at
 * @property int  $updated_at
 *
 * @property Product       $product
 * @property Profile       $profile
 * @property ReviewModer[] $reviewModers
 */
class Review extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'review';
	}

	const STATUS_ACTIVE = 2;
	const STATUS_WAITING = 1;
	const STATUS_DEACTIVE = 0;
	const TYPE_REVIEW = 1;
	const TYPE_QUESTION = 2;

	/**
	 * {@inheritdoc}
	 */
	public function behaviors()
	{
		return [
			TimestampBehavior::class,
		];
	}


	public function rules()
	{
		return [
		    [['profile_id','text','rating'], 'required'],
			[['profile_id', 'product_id', 'rating', 'status', 'created_at', 'updated_at'], 'default', 'value' => null],
			[['profile_id', 'product_id', 'reply_to', 'rating', 'status', 'created_at', 'company_id', 'updated_at', 'type'], 'integer'],
			[['text'], 'string'],
			[['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'id']],
			[['profile_id'], 'exist', 'skipOnError' => true, 'targetClass' => Profile::class, 'targetAttribute' => ['profile_id' => 'id']],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'profile_id' => 'Profile ID',
			'product_id' => 'Product ID',
			'text' => 'Text',
			'rating' => 'Rating',
			'status' => 'Status',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
			'type' => 'Type'
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getProduct()
	{
		return $this->hasOne(Product::class, ['id' => 'product_id']);
	}

    public function getCompany()
    {
        return $this->hasOne(Company::class, ['id' => 'company_id']);
    }

    public function getProfile()
    {
        return $this->hasOne(Profile::class, ['id' => 'profile_id']);
    }
	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getReviewModers()
	{
		return $this->hasMany(ReviewModer::class, ['review_id' => 'id']);
	}

	public function getReplyTo()
	{
		return $this->hasOne(self::class, ['id' => 'reply_to']);
	}

	public function getReplies()
	{
		return $this->hasMany(self::class, ['reply_to' => 'id']);
	}

	public function getCompanies()
    {
        return $this->hasMany(Company::class, ['id' => 'company_id'])->viaTable('company_reviews', ['review_id' => 'id']);
    }

	public function fields()
	{
		return array_merge(parent::fields(), ['replies', 'profile']);
	}
}
