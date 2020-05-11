<?php

namespace jakharbek\filemanager\models;

use jakharbek\filemanager\helpers\FileManagerHelper;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "files".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $slug
 * @property string $name
 * @property string $ext
 * @property string $file
 * @property string $folder
 * @property string $path
 * @property string $domain
 * @property int $created_at
 * @property int $updated_at
 * @property int $user_id
 * @property int $status
 * @property string $upload_data
 * @property string $params
 * @property int $size
 * @property string $link
 * @property string $linkAbsolute
 */
class Files extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 2;
    const STATUS_INACTIVE = 1;
    const STATUS_DELETED = 0;

    /**
     * @return int
     */
    public function setActive()
    {
        return $this->updateAttributes(['status' => self::STATUS_ACTIVE]);
    }

    /**
     * @return int
     */
    public function setInactive()
    {
        return $this->updateAttributes(['status' => self::STATUS_INACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'files';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(),
            [
                'timestamp' => [
                    'class' => TimestampBehavior::class,
                    'createdAtAttribute' => null
                ],
                'slug' => [
                    'class' => SluggableBehavior::class,
                    'attribute' => 'title',
                    'slugAttribute' => 'slug'
                ],
                'date_filter' => [
                    'class' => TimestampBehavior::className(),
                    'attributes' => [
                        ActiveRecord::EVENT_BEFORE_VALIDATE => ['date_create'],
                    ],
                ],
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description', 'name', 'file', 'folder', 'domain', 'upload_data', 'params', 'path'], 'string'],
            [['created_at', 'updated_at', 'user_id', 'status', 'size'], 'integer'],
            [['title', 'slug'], 'string', 'max' => 500],
            [['ext'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('main', 'ID'),
            'title' => Yii::t('main', 'Title'),
            'description' => Yii::t('main', 'Description'),
            'slug' => Yii::t('main', 'Slug'),
            'name' => Yii::t('main', 'Name'),
            'ext' => Yii::t('main', 'Ext'),
            'file' => Yii::t('main', 'File'),
            'folder' => Yii::t('main', 'Folder'),
            'domain' => Yii::t('main', 'Domain'),
            'created_at' => Yii::t('main', 'Created At'),
            'updated_at' => Yii::t('main', 'Updated At'),
            'user_id' => Yii::t('main', 'User ID'),
            'status' => Yii::t('main', 'Status'),
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if ($this->created_at == null) {
            $this->created_at = time();
        }

        if (!Yii::$app->user->isGuest) {
            $this->user_id = Yii::$app->user->id;
        }

        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }

    /**
     * {@inheritdoc}
     * @return FilesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FilesQuery(get_called_class());
    }

    /**
     * @return string
     */
    public function getLink()
    {
        return FileManagerHelper::getDomain($this->domain) . $this->folder . $this->file . "." . $this->ext;
    }

    public function getLinks()
    {
        return FileManagerHelper::getDomain($this->domain) . $this->folder . $this->file.'_low' . "." . $this->ext;
    }

    /**
     * @return string
     */
    public function getLinkAbsolute()
    {
        return FileManagerHelper::getDomain($this->domain, true) . $this->folder . $this->file . "." . $this->ext;
    }

    /**
     * @return array|false
     */
    public function fields()
    {
        $fields = [
            'link',
            'linkAbsolute'
        ];

        if($this->getIsImage()){
            $fields['thumbnails'] = 'imageThumbs';
        }

        unset($fields['upload_data']);
        return ArrayHelper::merge(parent::fields(), $fields);
    }

    public function getImageSrc()
    {
        return FileManagerHelper::getDomain($this->domain) . $this->folder . $this->file . "." . $this->ext;


    }
    private $videos_formats = ['mp4', 'mov', 'mkv', 'ogm', 'webm', 'wmv', 'flv'];
    public $src;
    public $type;

    public function getIsVideo()
    {
        if (in_array($this->type, $this->videos_formats)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return string
     */
    public function getDist()
    {
        return $this->path . $this->file . "." . $this->ext;
    }


    /**
     * @return bool
     */
    public function getIsImage()
    {
        return in_array($this->ext, FileManagerHelper::getImagesExt());
    }

    /**
     * @return mixed
     */
    public function getImageThumbs()
    {
        $thumbsImages = FileManagerHelper::getThumbsImage();
        foreach ($thumbsImages as &$thumbsImage) {
            $slug = $thumbsImage['slug'];
            $newFileDist = getenv("STATIC_URL").$this->folder.$this->file . "_".$slug . "." . $this->ext;
            $thumbsImage['src'] = $newFileDist;
            $thumbsImage['path'] = $this->path . $this->file . "_".$slug . "." . $this->ext;

        }
        return $thumbsImages;
    }
}