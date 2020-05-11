<?php

namespace common\models;

use common\behaviors\SlugBehavior;
use common\components\Categories;
use common\filemanager\behaviors\InputModelBehavior;
use common\filemanager\models\Files;
use common\modules\categories\behaviors\CategoryModelBehavior;
use common\modules\category\models\Category;
use common\modules\langs\components\ModelBehavior;
use common\modules\settings\models\Settings;
use common\modules\translit\LatinBehaviour;
use common\modules\translit\LatinTokenizer;
use common\modules\translit\TextInterpreter;

use jakharbek\filemanager\behaviors\FileRelationBehavior;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "post".
 *
 * @property int $id
 * @property int $profile_id
 * @property string $title
 * @property string $slug
 * @property string $description
 * @property string $text
 * @property string $tags
 * @property int $lang
 * @property string $lang_hash
 * @property int $created_at
 * @property int $updated_at
 * @property int $type
 * @property int $status
 * @property string $files
 * @property int $company_id
 * @property int $publish_time
 * @property int $top
 * @property int $view
 *
 * @property Company $company
 * @property Profile $profile
 */
class Post extends ActiveRecord
{
    const SCENARIO_SEARCH = "search";
    const STATUS_ACTIVE = 2;
    const STATUS_WAITING = 1;
    const STATUS_DEACTIVE = 0;
    const  TYPE_NEWS = 1;
    const  TYPE_BLOG = 2;
    const  TYPE_ARTICLE = 3;

    public $category_id;
    private $files_src;

    public static function tableName()
    {
        return 'post';
    }

    public static function doTranslate($plain)
    {
        if (\Yii::$app->language == 'uz' || \Yii::$app->language == 'oz') {
            $textInterpreter = new TextInterpreter();
            $textInterpreter->setTokenizer(new LatinTokenizer());
            $textInterpreter->addBehavior(new LatinBehaviour([]));
            $string = $textInterpreter->process($plain)->getText();

            return $string;
        }
        return '';
    }

    public static function find()
    {
        return (new PostQuery(static::class))->joinWith('postCategories');
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            'lang' => [
                'class' => \oks\langs\components\ModelBehavior::className(),
                'fill' => [
                    'files' => '',
                    'type' => '',
                    'status' => '',
                    'top' => '',
                    'category_id' => ''
                ],
            ],
            'publish_time' => [
                'class' => AttributeBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_VALIDATE => 'publish_time',
                ],
                'value' => function () {
                    if ($this->publish_time == null) {
                        return $this->publish_time = time();
                    }
                    return strtotime($this->publish_time);
                },
            ],
            'publish_time_find' => [
                'class' => AttributeBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_AFTER_FIND => 'publish_time',
                ],
                'value' => function () {
                    return date('d.m.Y', $this->publish_time);
                },
            ],
//            'slug' => [
//                'class' => SlugBehavior::class,
//                'attribute' => 'slug',
//                'attribute_title' => 'title',
//            ],
            [
                'class' => SluggableBehavior::class,
                'attribute' => 'title'
            ],
            \common\components\InputModelBehavior::class,

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['profile_id', 'lang', 'created_at', 'updated_at', 'type', 'status', 'company_id', 'top', 'view'], 'integer'],
            [['text',], 'string'],
            [['slug'], 'unique'],
            [['category_id', 'publish_time'], 'safe'],
            [['title', 'slug', 'description', 'tags', 'lang_hash', 'files'], 'string', 'max' => 255],
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
            'title' => 'Title',
            'slug' => 'Slug',
            'description' => 'Description',
            'text' => 'Text',
            'lang' => 'Lang',
            'lang_hash' => 'Lang Hash',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'type' => 'Type',
            'status' => 'Status',
            'files' => 'Files',
            'company_id' => 'Company ID',
            'publish_time' => 'Publish Time',
            'top' => 'Top',
            'view' => 'View',
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

    public function getPostCategories()
    {
        return $this->hasMany(PostCategories::class, ['post_id' => 'id']);
    }

    public function getCategories()
    {
        return $this->hasMany(Category::class, ['id' => 'category_id'])->via('postCategories');
    }

    public function getCategoryNew(){

        return PostCategories::findOne(['post_id' => $this->id]) ? : new Category();
    }


    public function fields()
    {
        return ArrayHelper::merge(parent::fields(), [
            'files' => function () {
                if (!empty($this->files)) {
                    return $this->getFiles()->all();
                }
            },
            'categories',
        ]);
    }

    public function getFiles()
    {
        return \jakharbek\filemanager\models\Files::find()->andWhere(['id' => explode(',', $this->files)]);
    }


    public function extraFields()
    {
        return [
            'profile',
            'company'
        ];
    }


    /**
     * @param int|null $lang
     * @return array|Posts|Posts[]|mixed|ActiveRecord|ActiveRecord[]
     */
    public function getTranslation(int $lang = null)
    {
        $translations = static::find()
            ->andWhere(['lang_hash' => $this->lang_hash])
            ->andWhere(['<>','lang',$this->lang])
            ->indexBy('lang')
            ->all();

        if($lang !== null){
            return $translations[$lang];
        }
        return $translations;
    }


    public function beforeSave($insert)
    {
        if (strlen($this->files) > 0) {
            $this->files = preg_replace('/^,/s', null, $this->files);
        }

        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }

}
