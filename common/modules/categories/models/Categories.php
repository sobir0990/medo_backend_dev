<?php

namespace common\modules\categories\models;

use common\models\Post;
use common\modules\categories\models\CategoriesQuery;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use common\modules\langs\components\Lang;
use common\modules\langs\components\ModelBehavior;


/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property int $root
 * @property int $lft
 * @property int $rgt
 * @property int $lvl
 * @property string $name
 * @property string $icon
 * @property int $icon_type
 * @property bool $active
 * @property bool $selected
 * @property bool $disabled
 * @property bool $readonly
 * @property bool $visible
 * @property bool $collapsed
 * @property bool $movable_u
 * @property bool $movable_d
 * @property bool $movable_l
 * @property bool $movable_r
 * @property bool $removable
 * @property bool $removable_all
 * @property string $description
 * @property string $slug      [varchar(255)]
 * @property string $type      [integer]
 * @property string $lang_hash [varchar(255)]
 * @property string $lang      [integer]
 */
class Categories extends \kartik\tree\models\Tree
//class Categories extends ActiveRecord
{
    const TYPE_COMPANY = 400;
    const TYPE_ENCYCLOPEDIA = 500;
    const TYPE_POST = 100;
    const TYPE_PROFILE = 200;
    const TYPE_PRODUCT = 300;

    public $child_allowed;
//    Import Purposes start
    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                'lang' => [
                    'class' => ModelBehavior::className(),
                    'attribute_hash' => 'lang_hash'
                ],
            ]
        );
    }
//    Import Purposes end

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'categories';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules[] = [
            ['name', 'description', 'slug'],
            'string'
        ];
        $rules[] = [
            ['type', 'lang_hash'],
            'safe'
        ];
        $rules[] = [
            ['lang'],
            'default',
            'value' => Lang::getLangId()
        ];
        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'root' => 'Root',
            'lft' => 'Lft',
            'rgt' => 'Rgt',
            'lvl' => 'Lvl',
            'active' => 'Active',
            'selected' => 'Selected',
            'disabled' => 'Disabled',
            'readonly' => 'Readonly',
            'visible' => 'Visible',
            'collapsed' => 'Collapsed',
            'movable_u' => 'Movable U',
            'movable_d' => 'Movable D',
            'movable_l' => 'Movable L',
            'movable_r' => 'Movable R',
            'removable' => 'Removable',
            'removable_all' => 'Removable All',
            'name' => 'Name',
            'icon' => 'Icon',
            'icon_type' => 'Icon Type',
            'slug' => 'Slug',
            'description' => 'Description',
            'image' => 'Image',
            'type' => 'Type',
            'lang' => 'Lang',
            'lang_hash' => 'Lang hash'
        ];
    }

    /**
     * @inheritdoc
     * @return CategoriesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CategoriesQuery(get_called_class());
    }

//    Import purposes
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if (!$this->isRoot()) {
                $root_id = $this->root;
                $root = $this::findOne($root_id);
                $this->type = $root->type;
            }
            return true;
        }

    }
//    Import purposes

    public function fields() {
        return array(
            'id',
            'name' => function($model) {
                if (\Yii::$app->language == 'oz') {
                    return Post::doTranslate($model->name);
                }
                return $model->name;
            },
            'slug',
        );
    }

    public function getLink() {
        return \Yii::$app->urlManager->createUrl(['news/category', 'slug' => $this->slug]);
    }

}
