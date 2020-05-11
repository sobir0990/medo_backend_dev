<?php
/**
 * Created by PhpStorm.
 * User: xurshid
 * Date: 2/4/19
 * Time: 11:23 AM
 */

namespace common\models;


class CompanyQuery extends \yii\db\ActiveQuery
{

    public function active()
{
    return $this->andWhere('[[company.status]]=2');
}

    /**
     * {@inheritdoc}
     * @return Company[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Company|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @inheritdoc
     * @return CompanyQuery|array
     */
    public function category($slug = null){
        $this->joinWith(['categories']);
        if($slug !== null){
            $this->where(['categories.slug' => $slug]);
        }
        return $this;
    }

}