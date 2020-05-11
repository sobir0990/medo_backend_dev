<?php

namespace common\modules\category\models;

use common\filemanager\behaviors\InputModelBehavior;
use common\models\CategoryQuery;
use common\modules\langs\components\Lang;
use jakharbek\filemanager\models\Files;
use oks\langs\components\ModelBehavior;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\SluggableBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string $name
 * @property int $parent_id
 * @property string $slug
 * @property string $icon
 * @property string $type
 * @property int $status
 * @property int $sort
 * @property int $lang
 * @property string $lang_hash
 */
class Category extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 10;
    const STATUS_NO_ACTIVE = 1;

    public $category_id;

    public function behaviors()
    {
        return [
            'lang' => [
                'class' => ModelBehavior::className(),
                'fill' => [
                    'name' => '',
                    'icon' => '',
                    'status' => '',
                    'slug' => '',
                ],
            ],
            [
                'class' => SluggableBehavior::class,
                'attribute' => 'name'
            ],
            'file_manager_model' => [
                'class' => InputModelBehavior::class,
                'delimitr' => ','
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id', 'sort', 'lang'], 'default', 'value' => null],
            [['status'], 'default', 'value' => Category::STATUS_ACTIVE],
            [['parent_id', 'status', 'sort', 'lang'], 'integer'],
            [['slug'], 'safe'],
            [['name', 'icon', 'type', 'lang_hash'], 'string', 'max' => 254],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'parent_id' => 'Parent ID',
            'status' => 'Status',
            'sort' => 'Sort',
            'lang' => 'Lang',
            'lang_hash' => 'Lang Hash',
        ];
    }

    public function fields()
    {
        return ArrayHelper::merge(parent::fields(), [
            'children',
            'icon' => function () {
                if (!empty($this->icon)) {
                    return $this->getIcon()->all();
                }
            },

        ]);
    }

    public function getIcon()
    {
        return Files::find()->andWhere(['id' => explode(',', $this->icon)]);
    }



    public function getChilds()
    {
        return $this->hasMany(self::class, ['parent_id' => 'id']);
    }

    public function getChildren()
    {
        return $this->hasMany(self::class, ['parent_id' => 'id']);
    }

    public function getParent()
    {
        return $this->hasOne(self::className(), ['id' => 'parent_id']);
    }

    public function getParentName()
    {
        $parent = $this->parent;

        return $parent ? $parent->name : '';
    }


    public static function statusList(): array
    {
        return [
            Category::STATUS_ACTIVE => 'Acive',
            Category::STATUS_NO_ACTIVE => 'No Active',
        ];
    }

    public static function statusName($status): string
    {
        return ArrayHelper::getValue(self::statusList(), $status);
    }

    public static function statusLabel($status): string
    {
        switch ($status) {
            case Category::STATUS_NO_ACTIVE:
                $class = 'label label-danger';
                break;
            case Category::STATUS_ACTIVE:
                $class = 'label label-success';
                break;
        }

        return Html::tag('span', ArrayHelper::getValue(self::statusList(), $status), [
            'class' => $class,
        ]);
    }

    public static function getList($slug = null)
    {
        if ($slug !== null) {
            $parent = self::findOne(['slug' => $slug]);
            return self::find()
                ->andWhere(['lang' => Lang::getLangId()])
                ->andWhere(['parent_id' => $parent->id])->select("name, id")
                ->indexBy('id')->column();
        }
        return self::find()->select("name, id")
            ->indexBy('id')->column();
    }

    public static function getVacation($slug = null)
    {
        if ($slug !== null) {
            $parent = self::findOne(['slug' => $slug]);
            return self::find()
                ->andWhere(['type' => 'Vacation'])
                ->select("name, id")
                ->indexBy('id')->column();
        }
        return self::find()->select("name, id")
            ->indexBy('id')->column();
    }

    /**
     * @param int|null $lang
     * @return array|Category|Category[]|mixed
     */
    public function getTranslation($withoutMe = true, int $lang = null)
    {
        $translations = static::find()
            ->andWhere(['lang_hash' => $this->lang_hash]);
        if ($withoutMe) {
            $translations->andWhere(['<>', 'lang', $this->lang]);
        }

        $translations = $translations->indexBy('lang')->all();

        if ($lang !== null) {
            return $translations[$lang];
        }

        return $translations;
    }

    public static function find()
    {
        $query = new CategoryQuery(get_called_class());
        return $query;
//        return $query->andWhere(['lang' => Lang::getLangId()]);
    }



    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

            if ($this->parent_id !== null) {
                $model = self::findOne($this->parent_id);
                $this->type = $model->name;
            }
            return true;
        }
    }


}
