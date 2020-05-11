<?php

namespace common\models;

use common\modules\category\models\Category;
use common\modules\langs\components\ModelBehavior;
use common\behaviors\SlugBehavior;
use jakharbek\filemanager\models\Files;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "encyclopedia".
 *
 * @property int     $id
 * @property int     $author_id
 * @property string  $title
 * @property string  $slug
 * @property string  $description
 * @property string  $text
 * @property int     $lang
 * @property string  $lang_hash
 * @property int     $created_at
 * @property int     $updated_at
 * @property int     $type
 * @property int     $status
 * @property string  $files
 * @property int     $publish_time
 * @property int     $top
 * @property int     $view
 * @property string  $letter
 * @property string  $reference
 *
 * @property Profile $author
 */
class Encyclopedia extends \yii\db\ActiveRecord
{
	const STATUS_CREATED = 0;
	const STATUS_DECLINED = 1;
	const STATUS_PENDING = 2;
	const STATUS_PUBLISHED = 3;
	const STATUS_REVIEWED = 4;
	private $files_src;
	public $_category;
    public $category_id;

	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'encyclopedia';
	}

	public function behaviors()
	{
		return [
			TimestampBehavior::class,
			'lang' => [
				'class' => ModelBehavior::class,
                'attribute_hash' => 'lang_hash',
				'fill' => [
					'title' => function ($value, $model) {
						return Post::doTranslate($value);
					},
					'text' => function ($value, $model) {
						return Post::doTranslate($value);
					},
					'description' => function ($value, $model) {
						return Post::doTranslate($value);
					}
				],
			],
			'slug' => [
				'class' => SlugBehavior::class,
				'attribute' => 'slug',
				'attribute_title' => 'title',
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
			[['title', 'text'], 'required'],
			[['author_id', 'lang', 'created_at', 'updated_at', 'type', 'status', 'top', 'category_id', 'view'], 'integer'],
			[['text', 'reference', '_category'], 'string'],
			[['title', 'slug', 'description', 'lang_hash', 'files'], 'string', 'max' => 255],
			[['letter'], 'string', 'max' => 8],
			[['view', 'status', 'publish_time'], 'default', 'value' => 0],
			[['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => Profile::class, 'targetAttribute' => ['author_id' => 'id']],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'author_id' => 'Author ID',
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
			'publish_time' => 'Publish Time',
			'top' => 'Top',
			'view' => 'View',
			'letter' => 'Letter',
		];
	}

	public function beforeSave($insert)
	{

        if (strlen($this->files) > 0) {
            $this->files = preg_replace('/^,/s', null, $this->files);
        }

        if (!$this->isNewRecord) {
            EncyclopediaCategories::deleteAll(['encyclopedia_id' => $this->id]);
        }

		if ($insert)
			$this->letter = mb_strtolower(mb_substr($this->title, 0, 1));
		if (!$insert && $this->status == self::STATUS_PUBLISHED) {
			$titles = self::find()->select('title, "encyclopedia".slug')->all();
			foreach ($titles as $title) {
				$reg = "/(\b{$title->title})/i";
				$repl = "<a href='/encyclopedia/".$title->slug;
				$repl.="/'>$1</a>";
				$this->text = preg_replace($reg, $repl, $this->text);
			}
		}


		return parent::beforeSave($insert);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getAuthor()
	{
		return $this->hasOne(Profile::class, ['id' => 'author_id']);
	}

	public function getReviewers()
	{
		return $this->hasMany(Profile::class, ['id' => 'profile_id'])
			->viaTable('encyclopedia_reviewers', ['encyclopedia_id' => 'id']);
	}

	public function getCategories()
	{
		return $this->hasMany(Category::class, ['id' => 'category_id'])
			->viaTable('encyclopedia_categories', ['encyclopedia_id' => 'id']);
	}

	public function getCategoryOrNew(){
        return $this->hasMany(Category::class, ['id' => 'category_id'])
            ->viaTable('encyclopedia_categories', ['encyclopedia_id' => 'id']);
    }

    public function getCategoryNew(){

        return EncyclopediaCategories::findOne(['encyclopedia_id' => $this->id]) ? : new EncyclopediaCategories();
    }

	public function getCategory()
	{
		return $this->_category;
	}

	public function setCategory($value)
	{
		return $this->_category = $value;
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
        return Files::find()->andWhere(['id' => explode(',', $this->files)]);
    }

    public function afterSave($insert, $attr = NULL)
    {
        $this->saveRelationItems();
        return parent::afterSave($insert, $attr = NULL);
    }

    public function saveRelationItems()
    {
        if (!empty($this->category_id)){
            $category = new EncyclopediaCategories();
            $category->encyclopedia_id = $this->id;
            $category->category_id = $this->category_id;
            $category->save();
        }
    }

    public function beforeDelete()
    {
        EncyclopediaCategories::deleteAll(['encyclopedia_id' => $this->id]);
        return parent::beforeValidate();
    }
//
//    public static function find()
//    {
//        return (new ActiveQuery(static::class))->joinWith('categories');
//    }
}
