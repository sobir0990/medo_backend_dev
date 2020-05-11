<?php

namespace common\models;

use common\components\Categories;
use common\modules\settings\models\Settings;
use common\components\InputModelBehavior;
use common\modules\langs\components\ModelBehavior;
use jakharbek\filemanager\models\Files;
use common\modules\category\models\Category;
use common\modules\translit\LatinBehaviour;
use common\modules\translit\LatinTokenizer;
use common\modules\translit\TextInterpreter;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property int $profile_id
 * @property int $company_id
 * @property string $images
 * @property int $type
 * @property int $status
 * @property int $price
 * @property int $price_type
 * @property string $phone
 * @property string $files
 * @property int $lang
 * @property string $lang_hash
 * @property int $delivery
 * @property string $address
 * @property int $top
 * @property int $view
 * @property int $view_phone
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Company $company
 * @property Profile $profile
 * @property Review[] $reviews
 * @property int $price_to
 * @property int $city_id
 * @property string $title_uz
 * @property string $content_uz
 * @property string $title_ru
 * @property string $content_ru
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    const STATUS_ACTIVE = 2;
    const STATUS_WAITING = 1;
    const STATUS_DEACTIVE = 0;

    const TYPE_PRODUCT = 0;
    const TYPE_SERVICE = 1;
    const TYPE_ANNOUNCE = 2;

    const PRICE_TYPE_AGREED = 1;
    const PRICE_TYPE_ACCURATE = 0;

    public $category_id;
    public $favorite;

    public static function tableName()
    {
        return 'product';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            InputModelBehavior::class,
        ];
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

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['profile_id'], 'required'],
            [['status'], 'default', 'value' => 0],
            [['profile_id', 'status', 'city_id', 'price', 'type', 'lang', 'view', 'view_phone', 'created_at', 'updated_at'], 'integer'],
            [['top', 'price_type', 'delivery'], 'boolean'],
            [['images', 'files', 'title_uz', 'title_ru', 'files', 'lang_hash', 'address'], 'string', 'max' => 255],
            [['phone', 'content_uz', 'content_ru'], 'string'],
            [['category_id', 'company_id', 'category'], 'safe'],
//            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::class, 'targetAttribute' => ['company_id' => 'id']],
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
            'images' => 'Images',
            'title_uz' => 'Title',
            'title_ru' => 'Title',
            'type' => 'Type',
            'status' => 'Status',
            'price' => 'Price',
            'price_type' => 'Price Type',
            'phone' => 'Phone',
            'files' => 'Files',
            'lang' => 'Lang',
            'lang_hash' => 'Lang Hash',
            'delivery' => 'Delivery',
            'address' => 'Address',
            'top' => 'Top',
            'view' => 'View',
            'view_phone' => 'View Phone',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'content_uz' => 'Content',
            'content_ru' => 'Content',
            'category_id' => 'category_id',
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Review::class, ['product_id' => 'id']);
    }

    public function getProductCategories()
    {
        return $this->hasMany(ProductCategories::class, ['product_id' => 'id']);
    }

    public function getCategories()
    {
        return $this->hasMany(Category::class, ['id' => 'category_id'])->via('productCategories');
    }

    public function getCategoryNew()
    {
        return ProductCategories::findOne(['product_id' => $this->id]) ?: new ProductCategories();
    }

    public function fields()
    {
        return [
            'id',
            'title' => function () {
                $title = 'title_' . \Yii::$app->language;
                return $this->{$title};
            },
            'content' => function () {
                $title = 'content_' . \Yii::$app->language;
                return $this->{$title};
            },
            'type',
            'status',
            'price',
            'price_type',
            'phone',
            'delivery',
            'city',
            'address',
            'top',
            'view',
            'view_phone',
            'company' => function () {
                if ($this->company_id !== 0 && $this->company_id !== "undefined ") {
                    return $this->company;
                }
            },
            'profile' => function () {
                return $this->profile;
            },
            'images' => function () {
                if (!empty($this->images)) {
                    return $this->getImages()->all();
                }
            },
            'files' => function () {
                if (!empty($this->files)) {
                    return $this->getFiles()->all();
                }
            },
            'favorite' => function () {
                return $this->favorite();
            },
            'categories',
            'created_at',
        ];
    }


    public function getFiles()
    {
        return Files::find()->andWhere(['id' => explode(',', $this->files)]);
    }

    public function getImages()
    {
        return Files::find()->andWhere(['id' => explode(',', $this->images)]);
    }


    public function extraFields()
    {
        return array_merge(parent::extraFields(), [
            'reviews',

        ]);
    }

    /**
     * @return int|string
     * @throws \yii\web\NotFoundHttpException
     */
    public function favorite()
    {
        $user = User::findAuthId();
        $profile_id = $user->profile->id;
        return $this->hasMany(FavoriteProduct::class, ['product_id' => 'id'])
            ->andWhere(['profile_id' => $profile_id])
            ->count();

    }


//    public static function find()
//    {
//        return (new ProductQuery(static::class))->joinWith(['city', 'productCategories']);
//    }


//    private function getData($categories)
//    {
//        $data = [];
//
//        if (is_string($categories)) {
//            $categories = explode(',', $categories);
//        }
//        foreach ($categories as $selected) {
//            $data[] = Categories::findOne((int)$selected);
//        }
//        return $data;
//
//    }

    public function afterSave($insert, $attr = NULL)
    {
        $this->saveRelationItems();
        return parent::afterSave($insert, $attr = NULL);
    }

    public function saveRelationItems()
    {
        if (!empty($this->category_id)) {
            $model = Category::find()
                ->andWhere(['id' => $this->category_id])
                ->one();


            $res = Category::find()
                ->andWhere(['lang_hash' => $model->lang_hash])
                ->andWhere(['NOT', ['"category".id' => $model->id]])
                ->one();
        }

        if (!empty($this->category_id)) {
            $category = new ProductCategories();
            $category->product_id = $this->id;
            $category->category_id = $this->category_id;
            $category->save();

            $category_2 = new ProductCategories();
            $category_2->product_id = $this->id;
            $category_2->category_id = $res->id;
            $category_2->save(false);
//            var_dump($res->id); exit;
        }
    }

    public function beforeDelete()
    {
        ProductCategories::deleteAll(['product_id' => $this->id]);
        return parent::beforeValidate();
    }


    public function beforeSave($insert)
    {
        if (strlen($this->files) > 0) {
            $this->files = preg_replace('/^,/s', null, $this->files);
        }

        if (strlen($this->images) > 0) {
            $this->images = preg_replace('/^,/s', null, $this->images);
        }

        if (!$this->isNewRecord) {
            ProductCategories::deleteAll(['product_id' => $this->id]);
        }

        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }
}
