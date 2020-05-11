<?php

namespace common\models;

use common\modules\category\models\Category;
use common\components\InputModelBehavior;
use jakharbek\filemanager\models\Files;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Query;

/**
 * This is the model class for table "company".
 *
 * @property int $id
 * @property int $profile_id
 * @property int $type
 * @property string $image
 * @property int $status
 * @property string $phone
 * @property string $address
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Profile $profile
 * @property Post[] $posts
 * @property Product[] $products
 * @property Social[] $socials
 * @property Vacation[] $vacations
 * @property Review[] $reviews
 * @property string $city_id [integer]
 * @property string $region_id [integer]
 * @property string $name_uz [varchar(255)]
 * @property string $description_uz
 * @property string $page_uz
 * @property string $name_ru [varchar(255)]
 * @property string $description_ru
 * @property string $page_ru
 */
class Company extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    const TYPE_MAINTAINER = 1;
    const TYPE_PROVIDER = 2;
    const TYPE_MED_INSTITUTE = 3;
    const TYPE_MED_SCHOOL = 4;
    const STATUS_DEACTIVE = 0;
    const STATUS_WAITING = 1;
    const STATUS_ACTIVE = 2;

    public $category_id;
    private $_category;

//    private $files_src;


    public static function tableName()
    {
        return 'company';
    }

    public static function find()
    {
        return (new CompanyQuery(static::class))->joinWith(['city', 'companyCategories']);
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            InputModelBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['profile_id', 'type', 'status', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['profile_id', 'type', 'status', 'city_id', 'region_id', 'created_at', 'updated_at'], 'integer'],
            [['category_id'], 'safe'],
            [['page_uz', 'page_ru'], 'string'],
            [['name_uz', 'name_ru', 'description_uz', 'description_ru', 'address', 'category'], 'string', 'max' => 255],
            [['image'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 20],
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
            'name_uz' => 'Name uzb',
            'name_ru' => 'Name rus',
            'type' => 'Type',
            'image' => 'Image',
            'status' => 'Status',
            'description' => 'Description',
            'phone' => 'Phone',
            'address' => 'Address',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profile::class, ['id' => 'profile_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::class, ['company_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::class, ['company_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSocials()
    {
        return $this->hasMany(Social::class, ['company_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getReviews()
    {
        return $this->hasMany(Review::class, ['id' => 'review_id'])
            ->viaTable('company_reviews', ['company_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::class, ['id' => 'city_id']);
    }

    public function getRegion()
    {
        return $this->hasOne(Region::class, ['id' => 'region_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVacations()
    {
        return $this->hasMany(Vacation::class, ['company_id' => 'id']);
    }

    public function getCompanyCategories()
    {
        return $this->hasMany(CompanyCategories::class, ['company_id' => 'id']);
    }

    public function getCategories()
    {
        return $this->hasMany(Category::class, ['id' => 'category_id'])->via('companyCategories');
    }

    public function getCategoryNew()
    {
        return CompanyCategories::findOne(['company_id' => $this->id]) ?: new Category();
    }

    public function getCategory()
    {
        return $this->_category;
    }

    public function setCategory($value)
    {
        return $this->_category = $value;
    }

    public function getMessages()
    {
        return $this->hasMany(Message::class, ['id' => 'message_id'])
            ->viaTable('company_message', ['company_id' => 'id']);

    }

    public function getCount()
    {
        $profile = Yii::$app->user->identity->profile;
        $count = Chat::find()
            ->leftJoin('profile', 'chat.user_1 = profile.id OR chat.user_2 = profile.id')
            ->andWhere(['profile.id' => $profile->id])
            ->andWhere(['company_id' => $this->id])
            ->count();
        return $count;
    }

    public function fields()
    {
        return [
            'id',
            'name' => function () {
                $title = 'name_' . \Yii::$app->language;
                return $this->{$title};
            },
            'type',
            'status',
            'description' => function () {
                $title = 'description_' . \Yii::$app->language;
                return $this->{$title};
            },
            'city',
            'phone',
            'address',
            'created_at',
            'updated_at',
            'categories',
            'page_uz',
            'page_ru',
            'image' => function () {
                if (!empty($this->image)) {
                    return $this->getImage()->all();
                }
            },
            'count' => function(){
            return $this->getCount();
            }
        ];
    }

    public function extraFields()
    {
        return [
            'profile',
            'products',
            'vacations',
            'posts',
            'categories',
            'socials',
            'messages',
            'reviews'
        ];
    }


    public function getImage()
    {
        return Files::find()->andWhere(['id' => explode(',', $this->image)]);
    }

    public function afterSave($insert, $attr = NULL)
    {
        $this->saveRelationItems();
        return parent::afterSave($insert, $attr = NULL);
    }

    public function saveRelationItems()
    {
        if (!empty($this->category_id)) {
            $category = new CompanyCategories();
            $category->company_id = $this->id;
            $category->category_id = $this->category_id;
            $category->save();
        }
    }

    public function beforeDelete()
    {
        CompanyCategories::deleteAll(['company_id' => $this->id]);
        return parent::beforeValidate();
    }

    public function beforeSave($insert)
    {
        if (strlen($this->image) > 0) {
            $this->image = preg_replace('/^,/s', null, $this->image);
        }

        if (!$this->isNewRecord) {
            CompanyCategories::deleteAll(['company_id' => $this->id]);
        }

        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }


}
