<?php

namespace common\models;

use common\filemanager\behaviors\InputModelBehavior;
use common\modules\categories\behaviors\CategoryModelBehavior;
use common\modules\categories\models\Categories;
use common\modules\category\models\Category;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "resume".
 *
 * @property int $id
 * @property int $profile_id
 * @property string $title
 * @property string $text
 * @property string $files
 * @property int $salary
 * @property string $phone
 * @property string $experience
 * @property int $salary_type
 * @property int $type
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Profile $profile
 * @property string $salary_to [integer]
 * @property string $city_id   [integer]
 * @property string $description
 * @property string $education [integer]
 * @property string $phone_view [integer]
 * @property string $view [integer]
 * @property string $place_id [integer]
 * @property string $name     [varchar(255)]
 * @property string $birthday [varchar(32)]
 */
class Resume extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 2;
    const STATUS_WAITING = 1;
    const STATUS_DEACTIVE = 0;
    const EDU_MASTER = 4;
    const EDU_HIGH = 3;
    const EDU_COLLEGE = 2;
    const EDU_SCHOOL = 1;
    public $category_id;
    private $_category;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'resume';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
           \common\components\InputModelBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['profile_id', 'salary', 'salary_type', 'salary_to', 'type', 'status', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['profile_id', 'education', 'salary', 'salary_type', 'city_id', 'type', 'status', 'place_id', 'created_at', 'updated_at'], 'integer'],
            [['title', 'files', 'text', 'experience', 'description', 'name', 'birthday'], 'string'],
            [['phone'], 'string', 'max' => 18],
            [['files'], 'file', 'extensions' => 'doc, docx, jpeg, jpg, png, pdf'],
            [['category', 'category_id'], 'safe'],
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
            'title' => 'Title',
            'text' => 'Text',
            'files' => 'Files',
            'salary' => 'Salary',
            'phone' => 'Phone',
            'experience' => 'Experience',
            'salary_type' => 'Salary Type',
            'type' => 'Type',
            'status' => 'Status',
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

    public function getResumeCategories()
    {
        return $this->hasMany(ResumeCategories::class, ['resume_id' => 'id']);
    }

    public function getCategories()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id'])->via('resumeCategories');
    }

    public function getCategoryNew(){

        return ResumeCategories::findOne(['resume_id' => $this->id]) ? : new ResumeCategories();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::class, ['id' => 'city_id']);
    }

    public function getCategory()
    {
        return $this->_category;
    }

    public function setCategory($value)
    {
        return $this->_category = $value;
    }

    public function getPlace()
    {
        return $this->hasOne(Categories::class, ['id' => 'place_id'])->onCondition(['categories.type' => 400]);
    }

    public function fields()
    {

        return [
            'id',
            'title',
            'text',
            'files' => function () {
                if (!empty($this->files)) {
                    return $this->getFiles()->all();
                }
            },
            'description',
            'education',
            'categories',
            'name',
            'birthday',
            'profile',
            'salary',
            'salary_to',
            'phone',
            'city',
            'experience',
            'salary_type',
            'type',
            'status',
            'place',
            'created_at',
            'updated_at',
        ];
    }

    public function getFiles()
    {
        return \jakharbek\filemanager\models\Files::find()->andWhere(['id' => explode(',', $this->files)]);
    }

    public function afterSave($insert, $attr = NULL)
    {
        $this->saveRelationItems();
        return parent::afterSave($insert, $attr = NULL);
    }

    public function saveRelationItems()
    {
        if (!empty($this->category_id)){
            $category = new ResumeCategories();
            $category->resume_id = $this->id;
            $category->category_id = $this->category_id;
            $category->save();
        }
    }

    public function beforeSave($insert, $attr = NULL)
    {
        if (strlen($this->files) > 0) {
            $this->files = preg_replace('/^,/s', null, $this->files);
        }

        if (!$this->isNewRecord) {
            ResumeCategories::deleteAll(['resume_id' => $this->id]);
        }
        return parent::beforeSave($insert, $attr); // TODO: Change the autogenerated stub
    }

    public function beforeDelete()
    {
        ResumeCategories::deleteAll(['resume_id' => $this->id]);
        return parent::beforeValidate();
    }

}


