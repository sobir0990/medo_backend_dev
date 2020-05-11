<?php
/**
 * @author O`tkir   <https://gitlab.com/utkir24>
 * @package prokuratura.uz
 *
 */

namespace common\filemanager\behaviors;

use Yii;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;
use \common\filemanager\models\Files;


class InputModelBehavior extends AttributeBehavior
{
    /**
     * @var string
     */
    public $delimitr = ',';

    /**
     * @param $attribute
     * @return array|bool|Files[]|\common\filemanager\models\FilesQuery
     */
    public function allFiles($attribute,$returnActiveQuery = false){
        $data = $this->owner->{$attribute};
        if($data === ''){return false;}
        if($data{0} === $this->delimitr)
        {
            $data = substr($data,1);
        }
        if(empty($data)){return false;}
        $data = explode($this->delimitr,$data);
        if(!is_array($data)){return false;}
        if(!count($data)){return false;}

        $elements = Files::find()->andWhere(['in', Files::primaryKey(), $data]);
        if($returnActiveQuery){return $elements;}
        return $elements->all();
    }

}