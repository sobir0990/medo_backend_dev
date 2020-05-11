<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

class BaseModel extends ActiveRecord
{
    const SCENARIO_SEARCH = 'search';
    const SCENARIO_INSERT = 'insert';
    const SCENARIO_UPDATE = 'update';

	const STATUS_PUBLISHED = 1;
	const STATUS_DRAFT     = 2;
	const STATUS_TRASH     = 3;


    public $search;

    public function is_serialized($data)
    {
        return (@unserialize($data) !== false);
    }

	public function generateUniqueRandomString( $attribute, $length = 32 )
	{
		$randomString = Yii::$app->getSecurity()->generateRandomString( $length );

		if( !$this->findOne( [ $attribute => $randomString ] ) )
		{
			$this->{$attribute} = $randomString;

			return true;

		} else
			return $this->generateUniqueRandomString( $attribute, $length );
	}

    public function afterFind()
    {
        parent::afterFind();
    }

    public function beforeSave($insert)
    {
        return parent::beforeSave($insert);
    }
}