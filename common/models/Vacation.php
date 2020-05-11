<?php

namespace common\models;

use common\filemanager\behaviors\InputModelBehavior;
use common\filemanager\models\Files;
use common\modules\categories\behaviors\CategoryModelBehavior;
use common\modules\categories\models\Categories;
use common\modules\category\models\Category;
use common\modules\settings\models\Settings;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "vacation".
 *
 * @property int     $id
 * @property int     $profile_id
 * @property int     $company_id
 * @property string  $title
 * @property string  $text
 * @property string  $files
 * @property int     $salary
 * @property string  $phone
 * @property string  $experience
 * @property int     $salary_type
 * @property int     $type
 * @property string  $address
 * @property int     $status
 * @property int     $created_at
 * @property int     $updated_at
 *
 * @property Company $company
 * @property Profile $profile
 * @property string  $salary_to [integer]
 * @property string  $city_id   [integer]
 * @property string  $description
 * @property string  $phone_view [integer]
 * @property string  $view       [integer]
 * @property string  $place_id   [integer]
 */
class Vacation extends \yii\db\ActiveRecord
{
    public $category_id;
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'vacation';
	}

	 const STATUS_ACTIVE = 2;
	 const STATUS_WAITING = 1;
	 const STATUS_DEACTIVE = 0;

	 const TYPE_FULL = 1;
	 const TYPE_PART = 2;
	 const TYPE_PROJECT = 3;
	 const TYPE_SHIFT = 4;
	 const TYPE_REMOTE = 5;

	private $_category;


	public function behaviors()
	{
		return [
			TimestampBehavior::class,
            InputModelBehavior::class,
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['profile_id', 'company_id', 'salary', 'salary_type', 'type', 'status', 'created_at', 'updated_at','files'], 'default', 'value' => null],
			[['profile_id', 'company_id', 'place_id', 'city_id', 'salary_type', 'type', 'status', 'view', 'phone_view', 'created_at', 'updated_at'], 'integer'],
			[['text', 'category', 'description'], 'string'],
			[['title', 'address'], 'string', 'max' => 255],
            [['files'], 'safe'],
			[['category_id', 'salary', 'salary_to'], 'safe'],
			['status', 'default', 'value' => 1],
            [['view', 'phone_view'], 'default', 'value' => 0],
			[['phone'], 'string', 'max' => 18],
			[['experience'], 'string', 'max' => 45],
			[['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::class, 'targetAttribute' => ['company_id' => 'id']],
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
			'company_id' => 'Company ID',
			'title' => 'Title',
			'text' => 'Text',
			'files' => 'Files',
			'salary' => 'Salary',
			'salary_to' => 'Salary To',
			'phone' => 'Phone',
			'experience' => 'Experience',
			'salary_type' => 'Salary Type',
			'type' => 'Type',
			'address' => 'Address',
			'status' => 'Status',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getCompany()
	{
		return $this->hasOne(Company::class, ['id' => 'company_id']);
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
	public function getCity()
	{
		return $this->hasOne(City::class, ['id' => 'city_id']);
	}

	public function getVacationCategories()
	{
		return $this->hasMany(VacationCategories::class, ['vacation_id' => 'id']);
	}

	public function getCategories()
	{
		return $this->hasMany(Category::class, ['id' => 'category_id'])->via('vacationCategories');
	}

	public function getCategory()
	{
		return $this->_category;
	}

	public function setCategory($value)
	{
		return $this->_category = $value;
	}

    public function getCategoryNew(){

        return VacationCategories::findOne(['vacation_id' => $this->id]) ? : new VacationCategories();
    }

    public function getPlace()
    {
        return $this->hasOne(Category::class, ['id' => 'place_id']);
	}

    public function fields()
    {
        return [
            'id',
            'title',
            'text',
            'description',
            'categories',
            'files' => function () {
                if (!empty($this->files)) {
                    return $this->getFiles()->all();
                }
            },
            'salary',
            'salary_to',
            'phone',
            'experience',
            'salary_type',
            'type',
            'city',
            'address',
            'view',
            'phone_view',
            'status',
            'company',
            'place_id',
            'profile',
            'created_at',
        ];
    }

    public function getFiles()
    {
        return \jakharbek\filemanager\models\Files::find()->andWhere(['id' => explode(',', $this->files)]);
    }

    public function extraFields()
    {
        return [
            'place'
        ];
    }

    public function afterSave($insert, $attr = NULL)
    {
        $this->saveRelationItems();
        return parent::afterSave($insert, $attr = NULL);
    }

    public function saveRelationItems()
    {
        if (!empty($this->category_id)){
            $category = new VacationCategories();
            $category->vacation_id = $this->id;
            $category->category_id = $this->category_id;
            $category->save();
        }
    }

    public function beforeDelete()
    {
        VacationCategories::deleteAll(['vacation_id' => $this->id]);
        return parent::beforeValidate();
    }

    public function beforeSave($insert)
    {
        if (strlen($this->files) > 0) {
            $this->files = preg_replace('/^,/s', null, $this->files);
        }

        if (!$this->isNewRecord) {
            VacationCategories::deleteAll(['vacation_id' => $this->id]);
        }

        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }


//    public static function find()
//    {
//        return (new ActiveQuery(static::class))->joinWith(['vacationCategories']);
//    }
}
