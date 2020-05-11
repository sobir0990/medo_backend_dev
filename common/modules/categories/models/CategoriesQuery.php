<?php

namespace common\modules\categories\models;

use common\modules\langs\components\Lang;
use common\modules\langs\components\QueryBehavior;
use creocoder\nestedsets\NestedSetsQueryBehavior;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the ActiveQuery class for [[Categories]].
 *
 * @see Category
 */
class CategoriesQuery extends \yii\db\ActiveQuery
{
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            NestedSetsQueryBehavior::className(),
            QueryBehavior::className(),
        ]);
    }

    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Category[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Category|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function allTypes()
    {
        return Yii::$app->params['categories_all_types'];
    }

    /**
     * @inheritdoc
     * @method - Build Tree
     * @param Array keys - keys which has been selected
     * @example [12 => [...meta...],15 => [...meta...]]
     * @return Array data
     */
    public function buildTreeByRoot($keys = [], $type = null)
    {
        $i = 0;
        if ($type == null) {
            $roots = Categories::find()->lang()->roots()->asArray()->all();
        } else {
            $roots = Categories::find()->lang()->type($type)->roots()->asArray()->all();
        }
        foreach ($roots as $root):
            $data[$i]['key'] = $root['id'];
            $data[$i]['title'] = $root['name'];
            if (array_key_exists($data[$i]['key'], $keys)) {
                $data[$i]['selected'] = true;
            }
            if (count($this->childrensById($root['id'])) > 0):
                $data[$i]['folder'] = true;
                $data[$i]['children'] = $this->childrensById($root['id'], $keys);
                $data[$i]['expanded'] = true;
            endif;
            $i++;
        endforeach;
        return $data;
    }

    private function lang()
    {
        return $this->andWhere(['lang' => Lang::getLangId()]);
    }

    public function type($type = null)
    {
        return $this->andWhere(['type' => $type]);
    }

    /**
     * @inheritdoc
     * @method - Build Tree by id
     * @param Array keys - keys which has been selected
     * @example [12 => [...meta...],15 => [...meta...]]
     * @return Array data
     */
    public function childrensById($id = null, $keys = [])
    {
        $i = 0;
        $count = Categories::findOne($id)->children(1)->count();
        if ($count == 0) {
            return [];
        }
        $data = [];
        $childs = Categories::findOne($id)->children(1)->orderBy('name')->asArray()->all();
        foreach ($childs as $child):
            $data[$i]['key'] = $child['id'];
            $data[$i]['title'] = $child['name'];
            if (!empty($child['icon'])) {
                $data[$i]['icon'] = getenv('STATIC_URL') . 'icons/' . $child['icon'];
            }
            if (array_key_exists($data[$i]['key'], $keys)) {
                $data[$i]['selected'] = true;
            }
            if (count($this->childrensById($child['id'])) > 0):
                $data[$i]['folder'] = true;
                $data[$i]['children'] = $this->childrensById($child['id'], $keys);
                $data[$i]['expanded'] = true;
            endif;
            $i++;
        endforeach;
        return $data;
    }

    public function slug($slug = null)
    {
        if ($slug == null) {
            return $this;
        }
        $this->andWhere(['slug' => $slug]);
        return $this;
    }
}
