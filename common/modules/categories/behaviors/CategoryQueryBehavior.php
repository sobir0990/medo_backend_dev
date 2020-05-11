<?php
namespace common\modules\categories\behaviors;

/**
 *
 * @author Jakhar <javhar_work@mail.ru>
 *
 */

use common\modules\categories\models\Categories;
use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

class CategoryQueryBehavior extends Behavior
{
    public function category($slug = null){
        $this->owner->joinWith(['categories']);
        if($slug !== null){
            $this->owner->where(['categories.slug' => $slug]);
        }
        return $this->owner;
    }
}