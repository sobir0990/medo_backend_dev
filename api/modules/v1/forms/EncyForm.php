<?php
/**
 * User: jamwid07
 * Date: 20/02/19
 */

namespace api\modules\v1\forms;

use common\modules\categories\models\Categories;
use common\models\Encyclopedia;
use oks\filemanager\models\Files;
use yii\base\Model;
use yii\web\UploadedFile;

class EncyForm extends Model
{
	public $author_id;
	public $title;
	public $slug;
	public $description;
	public $category_id;
	public $text;
	public $lang;
	public $lang_hash;
	public $type;
	public $status;
	public $files;
	public $publish_time;
	public $top;
	public $reference;


	public function rules()
	{
		return [
			[['title', 'text', 'slug'], 'required'],
			[['title', 'description', 'text', 'reference'], 'string'],
			[['status', 'publish_time', 'top', 'type'], 'integer'],
			[['category_id', 'author_id', 'slug', 'lang', 'lang_hash', 'files'], 'safe'],
		];
	}

	public function save()
	{
		if (!$this->validate()) {
			\Yii::$app->response->setStatusCode(422);
			return $this->getErrors();
		}

		if (!$model = Encyclopedia::findOne(['slug' => $this->slug])) {
			\Yii::$app->response->setStatusCode(201);
			$model = new Encyclopedia();
		}

		if ($model->isNewRecord) {
			$model->load($this->toArray(), '');
			$model->author_id = \Yii::$app->user->identity->profile->id;
			$model->status = Encyclopedia::STATUS_CREATED;
			$model->files = $this->files;
			if ($model->validate()) {
				$model->save();
			} else {
				\Yii::$app->response->setStatusCode(422);
				return $model->getErrors();
			}
		}
		if (is_array($this->category_id)) {
			$model->unlinkAll('categories', true);
			foreach ($this->category_id as $item) {
				$cat = Categories::findOne($item);
				$model->link('categories', $cat);
			}
		}
		return Encyclopedia::findOne($model->id);
	}
}
