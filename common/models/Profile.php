<?php

namespace common\models;

use common\filemanager\behaviors\InputModelBehavior;
use common\modules\categories\behaviors\CategoryModelBehavior;
use common\modules\categories\models\Categories;
use jakharbek\filemanager\models\Files;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Json;

/**
 * This is the model class for table "profile".
 *
 * @property int        $id
 * @property int        $user_id
 * @property string     $first_name
 * @property string     $last_name
 * @property string     $middle_name
 * @property string     $bio
 * @property int        $profession_id
 * @property int        $gender
 * @property int        $type
 * @property int        $status
 * @property int        $balance
 * @property int        $region_id
 * @property int        $city_id
 * @property string     $image
 * @property string     $social
 * @property int        $created_at
 * @property int        $updated_at
 *
 * @property Comment[]  $comments
 * @property Company[]  $companies
 * @property Message[]  $messages
 * @property Post[]     $posts
 * @property Product[]  $products
 * @property City       $city
 * @property Region     $region
 * @property User       $user
 * @property Resume[]   $resumes
 * @property Vacation[] $vacations
 * @property integer     $birth
 */
class Profile extends \yii\db\ActiveRecord
{
	private $files_src;
	public $category_id;
	const STATUS_DEACTIVE = 0;
	const STATUS_WAITING = 9;
	const STATUS_ACTIVE = 10;
	const TYPE_USER = 0;
	const TYPE_DOCTOR = 1;
	const MALE = 1;
	const FAMALE = 2;

	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'profile';
	}

	public function behaviors()
	{
		return [
			TimestampBehavior::class,
//			'category_model' => [
//				'class' => CategoryModelBehavior::class,
//				'attribute' => 'category',
//				'separator' => ',',
//			],
			'file_manager_model' => [
				'class' => InputModelBehavior::class,
				'delimitr' => ','
			],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['user_id'], 'required'],
			[['user'], 'safe'],
			[['user_id', 'gender', 'status', 'balance', 'profession_id', 'birth', 'region_id', 'city_id', 'category_id'], 'integer'],
			['type', 'boolean'],
			[['social', 'facebook', 'twitter', 'bio', 'instagram', 'google_plus', 'telegram'], 'string'],
			[['balance', 'type'], 'default', 'value' => 0],
			[['first_name', 'last_name', 'middle_name', 'image'], 'string', 'max' => 255],
			[['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::class, 'targetAttribute' => ['city_id' => 'id']],
			[['region_id'], 'exist', 'skipOnError' => true, 'targetClass' => Region::class, 'targetAttribute' => ['region_id' => 'id']],
			[['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'user_id' => 'User',
			'first_name' => 'First Name',
			'last_name' => 'Last Name',
			'middle_name' => 'Middle Name',
			'gender' => 'Gender',
			'type' => 'Type',
			'status' => 'Status',
			'balance' => 'Balance',
			'region_id' => 'Region ID',
			'city_id' => 'City ID',
			'image' => 'Image',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getComments()
	{
		return $this->hasMany(Comment::class, ['profile_id' => 'id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getCompanies()
	{
		return $this->hasMany(Company::class, ['profile_id' => 'id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getMessages()
	{
		return $this->hasMany(Message::class, ['from_user' => 'id']);
	}

	/**
	 * @param int|null $company_chat
	 * @return \yii\db\ActiveQuery
	 */
	public function getChats(int $company_chat = null)
	{
		$chats = $this->hasMany(Chat::class, ['user_1' => 'id']);
		if ($company_chat) $chats->andOnCondition(['chat.company_id' => $company_chat]);
		return $chats;
	}


	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getPosts()
	{
		return $this->hasMany(Post::class, ['profile_id' => 'id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getProducts()
	{
		return $this->hasMany(Product::class, ['profile_id' => 'id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getCity()
	{
		return $this->hasOne(City::class, ['id' => 'city_id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getRegion()
	{
		return $this->hasOne(Region::class, ['id' => 'region_id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getUser()
	{
		return $this->hasOne(User::class, ['id' => 'user_id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getResumes()
	{
		return $this->hasMany(Resume::class, ['profile_id' => 'id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getReview()
	{
		return $this->hasMany(Review::class, ['profile_id' => 'id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getVacations()
	{
		return $this->hasMany(Vacation::class, ['profile_id' => 'id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getProfilecategories()
	{
		return $this->hasMany(ProfileCategories::class, ['profile_id' => 'id']);
	}

	public function getCategories()
	{
		return $this->hasMany(Categories::class, ['id' => 'category_id'])->viaTable('profile_categories', ['profile_id' => 'id']);
	}

	public function getProfession()
	{
		return $this->hasMany(Categories::class, ['id' => 'profession_id']);
	}

    public function getCategoryNew()
    {
        return ProfileCategories::findOne(['profile_id' => $this->id]) ?: new ProfileCategories();
    }

	public function getCategory()
	{
		return $this->_category;
	}

	public function setCategory($value)
	{
		return $this->_category = $value;
	}


    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
	public function getFavoriteProduct()
	{
		return $this->hasMany(Product::class, ['id' => 'product_id'])->viaTable('favorite_product', ['profile_id' => 'id']);
	}

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
	public function getFavoriteVacation()
	{
		return $this->hasMany(Vacation::class, ['id' => 'vacation_id'])->viaTable('favorite_vacations', ['profile_id' => 'id']);
	}

	public function fields()
	{
		return [
			'id',
			'first_name',
			'last_name',
			'middle_name',
			'gender',
            'birth',
			'type',
			'balance',
			'created_at',
			'updated_at',
			'profession' => function(){
		    return $this->getProfession()->one();
            },
            'phone' => function () {
                return $this->user->phone;
            },
            'image' => function () {
                if (!empty($this->image)) {
                    return $this->getImage()->one();
                }
            },
			'status',
            'bio',
            'profession_id',
			'categories',
			'region',
			'city',
            'announce_count' => function () {
		        return $this->getProducts()->where(['company_id' => null])->count();
            },
			'social' => function () {
				return $this->getSocialInfo();
			}
		];
	}


    public function getImage()
    {
        return $this->hasOne(Files::className(), ['id' => 'image']);
    }

	public function extraFields()
	{
		return array_merge(parent::extraFields(), [
			'user',
			'comments',
			'companies',
			'messages',
			'posts',
			'products',
			'resumes',
			'reviews',
			'vacations',
			'chats',
		]);
	}

	/**
	 * @param null $r
	 * @return mixed
	 */
	public function getSocialInfo($r = null)
	{
		return Json::decode($this->social);
	}

	/**
	 * @param $value
	 * @return string
	 */
	public function setSocialInfo($value)
	{
		return $this->social = Json::encode($value);
	}

	/**
	 * @return mixed
	 */
	public function getTwitter()
	{
		return @$this->socialinfo['twitter'];
	}

	/**
	 * @param $value
	 * @return mixed
	 */
	public function setTwitter($value)
	{
		$social = $this->socialinfo;
		@$social['twitter'] = $value;
		$this->socialinfo = $social;
		return $social['twitter'];
	}

	/**
	 * @return mixed
	 */
	public function getFacebook()
	{
		return @$this->socialinfo['facebook'];
	}

	/**
	 * @param $value
	 * @return mixed
	 */
	public function setFacebook($value)
	{
		$social = $this->socialinfo;
		@$social['facebook'] = $value;
		$this->socialinfo = $social;
		return $social['facebook'];
	}


	/**
	 * @return mixed
	 */
	public function getInstagram()
	{
		return @$this->socialinfo['instagram'];
	}

	/**
	 * @param $value
	 * @return mixed
	 */
	public function setInstagram($value)
	{
		$social = $this->socialinfo;
		@$social['instagram'] = $value;
		$this->socialinfo = $social;
		return $social['instagram'];
	}


	/**
	 * @return mixed
	 */
	public function getGoogle_plus()
	{
		return @$this->socialinfo['google_plus'];
	}

	/**
	 * @param $value
	 * @return mixed
	 */
	public function setGoogle_plus($value)
	{
		$social = $this->socialinfo;
		@$social['google_plus'] = $value;
		$this->socialinfo = $social;
		return $social['google_plus'];
	}

	/**
	 * @return mixed
	 */
	public function getTelegram()
	{
		return @$this->socialinfo['telegram'];
	}

	/**
	 * @param $value
	 * @return mixed
	 */
	public function setTelegram($value)
	{
		$social = $this->socialinfo;
		@$social['telegram'] = $value;
		$this->socialinfo = $social;
		return $social['telegram'];
	}

    public function afterSave($insert, $attr = NULL)
    {
        $this->saveRelationItems();
        return parent::afterSave($insert, $attr = NULL);
    }

    public function saveRelationItems()
    {
        if (!empty($this->category_id)){
            $category = new ProfileCategories();
            $category->profile_id = $this->id;
            $category->category_id = $this->category_id;
            $category->save();
        }
    }

    public function beforeDelete()
    {
        ProfileCategories::deleteAll(['profile_id' => $this->id]);
        return parent::beforeValidate();
    }

    public function beforeSave($insert, $attr = NULL)
    {
        if (strlen($this->image) > 0) {
            $this->image = preg_replace('/^,/s', null, $this->image);
        }

        return parent::beforeSave($insert, $attr); // TODO: Change the autogenerated stub
    }



}
