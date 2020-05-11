<?php

namespace common\components;

use common\modules\translit\LatinBehaviour;
use common\modules\translit\LatinTokenizer;
use common\modules\translit\TextInterpreter;
use GuzzleHttp\Client;
use oks\filemanager\models\Files;
use yii\base\Component;

class Utils extends Component {

	public static function downloadPhotoFromUrl($photo_url)
	{
		$filename = \Yii::$app->security->generateRandomString(50);
		$data = Files::parse($filename);

		$folder = $data["folder"];
		$parsed_filename = $data["file"];

		$photo = $photo_url;

		if (!is_dir(\Yii::getAlias("@static") . "/uploads/$folder")) {
			mkdir(\Yii::getAlias("@static") . "/uploads/$folder", 777);
		}

		try {
			$file = fopen(\Yii::getAlias("@static") . "/uploads/$folder/$parsed_filename.png", "w");
			$httpclient = new Client();
			$picture = $httpclient
				->get($photo)
				->getBody()
				->getContents();
			fwrite($file, $picture);
			fclose($file);

			$file = new Files();
			$file->title = $parsed_filename;
			$file->type = "png";
			$file->user_id = 1;
			$file->file = $filename;
			$file->runUpload = false;
			$file->save();

			return $file->file_id;

		} catch (\Exception $e) {
			echo $e->getFile().":".$e->getLine()."\n".$e->getMessage();
		}

	}

	public function translateToLatin($plain) {
        if (\Yii::$app->language == 'uz' || \Yii::$app->language == 'oz') {
            $textInterpreter = new TextInterpreter();
            $textInterpreter->setTokenizer(new LatinTokenizer());
            $textInterpreter->addBehavior(new LatinBehaviour([]));

            $string = $textInterpreter->process($plain)->getText();

            return $string;
        }

        return '';
    }

}