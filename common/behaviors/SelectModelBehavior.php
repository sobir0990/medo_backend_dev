<?php
/**
 * Created by PhpStorm.
 * User: utkir
 * Date: 28.08.2018
 * Time: 11:55
 */

namespace common\behaviors;


use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * Class SelectModelBehavior
 * @package common\behaviors
 */
class SelectModelBehavior extends Behavior
{

    /**
     * @var
     */
    public $find_column='id';

    /**
     * @var string
     */
    public $relation_class_name='tag';
    /**
     * @var
     */
    public $attribute;
    /**
     * @var
     */
    public $relation_name;
    /**
     * @var
     */

    /**
     * @return array
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'saveData',
            ActiveRecord::EVENT_AFTER_UPDATE => 'saveData',
            ActiveRecord::EVENT_AFTER_FIND => 'afterFind'
        ];
    }

    /**
     *
     */
    public function saveData($event)
    {
        /**
         * @var $model ActiveRecord
         */

        if(!$this->owner->isNewRecord){
            $this->unlinkData();
        }
        if(is_array($this->owner->{$this->attribute})){
        $model = $this->relation_class_name;
            foreach ($this->owner->{$this->attribute} as $item){
                if($fixture = $model::findOne([$this->find_column => $item])){
                    $this->owner->link($this->relation_name,$fixture);
                }
            }
        }

    }

    /**
     * @return bool
     */
    private function unlinkData()
    {
        $relation_data = $this->owner->{$this->relation_name};
        if (count($relation_data) == 0) {
            return false;
        }
        foreach ($relation_data as $data):
            $this->owner->unlink($this->relation_name, $data, true);
        endforeach;
    }

    /**
     * @param $event
     */
    public function afterFind($event)
    {
        $this->owner->{$this->attribute} = ArrayHelper::getColumn($this->owner->{$this->relation_name},$this->find_column);

    }

}