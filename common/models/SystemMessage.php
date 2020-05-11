<?php

namespace common\models;

use Yii;
use yii\caching\TagDependency;
use yii\data\ActiveDataProvider;
use yii\db\Exception;

class SystemMessage extends BaseModel
{
    const CACHE_TAG = 'messages';
    public $search;
    public $language;
    public $translation;

    public static function tableName()
    {
        return '_system_message';
    }

    public function rules()
    {
        return [
            [['category'], 'string', 'max' => 128],
            [['message'], 'string', 'max' => 4096],
            [['search', 'language'], 'safe', 'on' => ['search']],
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        $this->invalidateTranslation();
        parent::afterSave($insert, $changedAttributes);
    }

    public function afterDelete()
    {
        $this->invalidateTranslation();
        parent::afterDelete();
    }


    public function invalidateTranslation()
    {
        TagDependency::invalidate(Yii::$app->cache, [self::CACHE_TAG]);
    }

    public function attributeLabels()
    {
        return [
            'id'          => __('ID'),
            'category'    => __('Category'),
            'translation' => __('Translation'),
            'language'    => __('Language'),
            'message'     => __('Message'),
            'search'      => __('Search by Message / Translation'),
        ];
    }

    public function getSystemMessageTranslations()
    {
        return $this->hasMany(SystemMessageTranslation::className(), ['id' => 'id']);
    }

    public function search($params)
    {
        $this->load($params);
        $query = self::find()
                     ->select(['m.*', 'translation' => 't.translation'])
                     ->from(['m' => self::tableName()])
                     ->leftJoin(
                         ['t' => SystemMessageTranslation::tableName()],
                         "t.id = m.id ");


        $dataProvider = new ActiveDataProvider([
		   'query'      => $query,
		   'sort'       => [
			   'defaultOrder' => ['id' => 'DESC'],
			   'attributes'   => [
				   'id',
				   'translation',
				   'message',
			   ],
		   ],
		   'pagination' => [
			   'pageSize' => 15,
		   ],
		]);

        $this->load($params);

        if ($this->search)
        {
			$query->orFilterWhere(['like', 'message', $this->search])
				->orFilterWhere(['like', 'translation', $this->search]);
        }

        return $dataProvider;
    }

    public function addTranslations($data)
    {
        $insert = [];

        foreach ($data as $lang => $translation)
        {
            $insert[] = [
                'id'          => $this->id,
                'language'    => $lang,
                'translation' => $translation,
            ];
        }

        if ( count( $insert ) )
        {
            $transaction = Yii::$app->db->beginTransaction();

            try {

				$this->invalidateTranslation();

                Yii::$app->db
                    ->createCommand()
                    ->delete(SystemMessageTranslation::tableName(), ['id' => $this->id])
                    ->execute();

                Yii::$app->db
                    ->createCommand()
                    ->batchInsert(SystemMessageTranslation::tableName(), ['id', 'language', 'translation'], $insert)
                    ->execute();

				$this->invalidateTranslation();
                $transaction->commit();

                return true;

            } catch (Exception $e) {
                $transaction->rollBack();
            }
        }

        return false;
    }

    public function changeTranslation($lang, $translation)
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            Yii::$app->db
                ->createCommand()
                ->delete(SystemMessageTranslation::tableName(), ['id' => $this->id, 'language' => $lang])
                ->execute();

            Yii::$app->db
                ->createCommand()
                ->insert(SystemMessageTranslation::tableName(), ['id' => $this->id, 'language' => $lang, 'translation' => $translation])
                ->execute();

            $transaction->commit();
            $this->invalidateTranslation();
            return true;
        } catch (Exception $e) {
            $transaction->rollBack();
        }
        return false;
    }
}
