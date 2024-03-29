<?php
/**
 *  @author Jakhar <jakharbek@gmail.com>
 *  @company OKS Technologies <info@oks.uz>
 *  @package YoshlarTV
 */

namespace common\modules\settings\models;


use common\filemanager\models\Files;
use common\filemanager\widgets\InputModalWidget;
use Yii;
use \yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use common\modules\langs\models\Langs;
use common\modules\langs\components\ModelBehavior;

/**
 * This is the model class for table "settings".
 *
 * @property int $setting_id
 * @property string $title Название
 * @property string $description Описание
 * @property string $slug Слаг
 * @property int $type Тип
 * @property int $input Инпут
 * @property string $default По умолчание
 * @property int $sort Сортировка
 * @property string $lang_hash Хеш языка
 * @property int $lang Язык
 *
 * @property Langs $lang0
 */
class Settings extends \yii\db\ActiveRecord
{
    const DESCRIPTION = "Настройки сайта";

    const SCENARIO_SEARCH = "search";
    const STATUS_ACTIVE = 1;
    /**
     * @return array
     */
    public function behaviors()
        {
        return ArrayHelper::merge(parent::behaviors(),[
//            'lang' => [
//                'class' => ModelBehavior::className(),
//                'fill' => [
//                    'title' => '',
//                    'slug' => '',
//                    'type' => '',
//                    'input' => '',
//                ]
//            ],
        ]); // TODO: Change the autogenerated stub

    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'settings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['type', 'input', 'sort', 'lang','data'], 'default', 'value' => null],
            [['data'],'safe'],
            [['title'], 'string', 'max' => 500],
            [['slug'], 'string', 'max' => 600],
            [['default', 'lang_hash'], 'string', 'max' => 255],
            [['lang'], 'exist', 'skipOnError' => true, 'targetClass' => Langs::className(), 'targetAttribute' => ['lang' => 'lang_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'setting_id' => 'Setting ID',
            'title' => 'Title',
            'description' => 'Description',
            'slug' => 'Slug',
            'type' => 'Type',
            'input' => 'Input',
            'default' => 'Default',
            'sort' => 'Sort',
            'data' => 'Data',
            'lang_hash' => 'Lang Hash',
            'lang' => 'Lang',
        ];
    }



    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLang0()
    {
        return $this->hasOne(Langs::className(), ['lang_id' => 'lang'])->inverseOf('settings');
    }

    /**
     * @inheritdoc
     * @return SettingsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SettingsQuery(get_called_class());
    }

    /**
     * @param $form
     * @param null $name
     * @param null $value
     * @return string
     * @throws \Exception
     */
    public function generateForm(&$form, $name = null, $value = null){
        /**
        *   1 => 'input',
               2 => 'select',
               5 => 'textarea'
        */
       $formname = $name;
       if($this->input == 1){

           if($value == null){
               $value = $this->values[0]->value;
               if(!strlen($value) > 1){
                   $value = $this->default;
               }
               if(!count($this->values)){
                   $value = $this->default;
               }
           }

           if($name == null){
               $name = $this->slug;
               $formname = "SettingsValues[".base64_encode($name)."][".$this->setting_id."][]";
           }

           $r  = "";
           $r .= "<div class='row form-group'>";
               $r .= \yii\helpers\Html::label($this->title.":<br /><span class='label label-info'>".$this->description."</span>");
               $r .= \yii\helpers\Html::input('text',$formname, $value,['class' => 'form-control']);
           $r .= "</div>";

           return $r;
       }
        if($this->input == 5){

            if($value == null){
                $value = $this->values[0]->value;
                if(!strlen($value) > 1){
                    $value = $this->default;
                }
                if(!count($this->values)){
                    $value = $this->default;
                }
            }

            if($name == null){
                $name = $this->slug;
                $formname = "SettingsValues[".base64_encode($name)."][".$this->setting_id."][]";
            }

            $r  = "";
            $r .= "<div class='row form-group'>";
            $r .= \yii\helpers\Html::label($this->title.":<br /><span class='label label-info'>".$this->description."</span>");
            $r .= \yii\helpers\Html::textarea($formname, $value,['class' => 'form-control','style' => 'height:200px; width:100%;']);
            $r .= "</div>";

            return $r;
        }
        if($this->input == 2){

            if($value == null){
                $value = $this->values[0]->value;
                if(!strlen($value) > 1){
                    $value = $this->default;
                }
                if(!count($this->values)){
                    $value = $this->default;
                }
            }

            if($name == null){
                $name = $this->slug;
                $formname = "SettingsValues[".base64_encode($name)."][".$this->setting_id."][]";
            }
            $list = [];
            $elements_temp1 = explode(";",$this->data);
            foreach ($elements_temp1 as $element_tp){
                $elements_temp2 = explode(":",$element_tp);
                $list[$elements_temp2[0]] = $elements_temp2[1];
            }

            $r  = "";
            $r .= "<div class='row form-group'>";
            $r .= \yii\helpers\Html::label($this->title.":<br /><span class='label label-info'>".$this->description."</span>");
            $r .= \yii\helpers\Html::dropDownList($formname, $value,$list,['class' => 'form-control']);
            $r .= "</div>";

            return $r;
        }
        if($this->input == 6){
            if($value == null){
                $value = $this->values[0]->value;
                if(!strlen($value) > 1){
                    $value = $this->default;
                }
                if(!count($this->values)){
                    $value = $this->default;
                }
            }

            if($name == null){
                $name = $this->slug;
                $formname = "SettingsValues[".base64_encode($name)."][".$this->setting_id."][]";
            }

            $r = "";
            $r .= "<div class='form-group'>";
            $r .= \yii\helpers\Html::label($this->title.":<br /><span class='label label-info'>".$this->description."</span>");
            $r .= InputModalWidget::widget(['form' => $form,
                'attribute' => $formname,
                'id' => 'filesform'.$this->setting_id,
                'values' => $value,
                'value_encode' => true
            ]);
            $r .= "</div>";
            return $r;
        }

    }

    /**
     *
     */
    public static function saveLisiner(){
        if($post = Yii::$app->request->post("SettingsValues")){
            foreach ($post as $settings){
                foreach ($settings as $setting_id => $value_all){
                     foreach ($value_all as $value){

                     $setting = Settings::findOne($setting_id);
                     $values_data = $setting->values;
                     foreach ($values_data as $vd){
                         $vd->delete();
                     }

                     $setting->unlinkAll('values',true);
                         $value = preg_replace("#^,#",null,$value);
                         $value = preg_replace("#,$#",null,$value);
                     $new_value = new Values();
                     $new_value->type = $setting_id;
                     $new_value->value = $value;
                     $new_value->save();

                     $setting->link('values',$new_value);


                     }
                }
            }
        }
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSettingsvalues()
    {
        return $this->hasMany(Settingsvalues::className(), ['setting_id' => 'setting_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getValues()
    {
        return $this->hasMany(Values::className(), ['value_id' => 'value_id'])->viaTable('settingsvalues', ['setting_id' => 'setting_id']);
    }

    /**
     * @param null $slug
     * @return array|string
     */
    public static function value($slug = null){
        $query = Settings::find()->slug($slug);
        $setting = clone $query;
        $setting = $setting->one();
        if($query->count() > 0){
            $values = $setting->values;
            if(count($values)){
                $data = $values[0]->value;
                //file
                if($setting->input == 6){
                    if(strlen($data) == 0){
                        return "";
                    }
                    $files_data = explode(",",$data);
                    $files = Files::find()->where(['file_id' => $files_data])->all();
                    return $files;
                }
                //input
                if($setting->input == 1){
                    if(strlen($data) == 0){
                        return $setting->default;
                    }else{
                        return $data;
                    }
                }
                //textarea
                if($setting->input == 5){
                    if(strlen($data) == 0){
                        return $setting->default;
                    }else{
                        return $data;
                    }
                }
                //textarea
                if($setting->input == 2){
                    if(strlen($data) == 0){
                        return [$setting->default => $setting->selectList[$setting->default],'id' => $setting->default,'value' => $setting->selectList[$setting->default]];
                    }else{
                        return [$data => $setting->selectList[$data],'id' => $data,'value' => $setting->selectList[$data]];
                    }
                }
            }
        }else{
            //file
            if( $setting->input == 6){
                    return "";
            }
            //input
            if($setting->input == 1){
                    return $setting->default;
            }
            //textarea
            if($setting->input == 5){
                    return $setting->default;
            }
            //textarea
            if($setting->input == 2){
                    return [$setting->default => $setting->selectList[$setting->default],'id' => $setting->default,'value' => $setting->selectList[$setting->default]];

            }
        }
    }

    /**
     * @return array
     */
    public function getSelectList(){
        $list = [];
        $elements_temp1 = explode(";",$this->data);
        foreach ($elements_temp1 as $element_tp){
            $elements_temp2 = explode(":",$element_tp);
            $list[$elements_temp2[0]] = $elements_temp2[1];
        }
        return $list;
    }

    /**
     * @return array|string
     */
    public function getValue(){
        $data = self::value($this->slug);
        return $data;
    }

    public function fields()
    {
        return array(
            'title',
            'slug',
            'value'
        );
    }

}
