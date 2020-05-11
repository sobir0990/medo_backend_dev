<?php


namespace backend\controllers;


use common\filemanager\helpers\FileManagerHelper;
use common\models\Company;
use common\models\Post;
use common\models\Product;
use common\modules\category\models\Category;
use igogo5yo\uploadfromurl\UploadFromUrl;
use jakharbek\filemanager\dto\GeneratedPathFileDTO;
use jakharbek\filemanager\dto\GeneratePathFileDTO;
use jakharbek\filemanager\models\Files;
use Yii;
use yii\helpers\Inflector;
use yii\web\Controller;

class FileController extends Controller
{
    const UPLOAD_DIR = 'uploads';

    public $title;
    public $description;
    public $upload_data = [];


    public function actionIndex()
    {
//        $categories = Category::find()
//            ->each(4);
//
//        foreach ($categories as $category) {
//            $this->actionPost($category);
//        }

//        $this->actionPost(Post::findOne(251));
    }

    public function actionPost($category)
    {
        /**
         * @var $files Files[]
         * @var $category Category
         */
        $files = FileManagerHelper::getFilesById($category->icon);
        $data = null;

        foreach ($files as $file) {
            if ($file->type == null || strlen($file->type) == 0) {
                continue;
            }
            /**
             * TODO - PATH
             */
            $folder = mb_substr($file->file, 0, 2);
            $url = mb_substr($file->file, 2);

            $paths = getenv('STATIC_URL') . '/' . self::UPLOAD_DIR . '/' . $folder . '/' . $url . '.' . $file->type;
            $source = Yii::getAlias('@static/uploads/') . $folder. '/';
            if (!file_exists($source. $url . '.' . $file->type)) {
                continue;
            }

            $file = UploadFromUrl::initWithUrl($paths);
            $generatePathDTO = new GeneratePathFileDTO();
            $generatePathDTO->file = $file;
            $generatePathDTO->useFileName = $file->baseName;
            $generatePath = $this->generatePath($generatePathDTO, $source);
            $data .= $generatePath->id;
        }
        if ($data !==null) {
            $category->updateAttributes(['icon' => $data]);
        }
        return $category;
    }

    private function generatePath(GeneratePathFileDTO $generatePathFileDTO, $source)
    {
        $generatedPathFileDTO = new GeneratedPathFileDTO();
        $created_at = time();

        $file = $generatePathFileDTO->file;
        $y = date("Y", $created_at);
        $m = date("m", $created_at);
        $d = date("d", $created_at);
        $h = date("H", $created_at);
        $i = date("i", $created_at);


        $folders = [
            $y,
            $m,
            $d,
            $h,
            $i
        ];

        $file_hash = Yii::$app->security->generateRandomString(64);
        $file_name = Inflector::transliterate($file->baseName);
        $basePath = Yii::getAlias('@static/' . getenv("UPLOAD_DIR"));
        $folderPath = getenv("UPLOAD_DIR");
        foreach ($folders as $folder) {
            $basePath .= $folder . "/";
            $folderPath .= $folder . "/";
            if (!is_dir($basePath)) {
                mkdir($basePath, 0777);
                chmod($basePath, 0777);
            }
        }
        if (!is_writable($basePath)) {
            throw new \DomainException("Path is not writeable");
        }
        $generatedPathFileDTO->file_folder = $basePath;

        $path = $basePath . $file_hash . "." . $file->extension;

        $model = new Files();
        $model->title = $file_name;
        $model->name = $file_name;
        $model->description = $file_name;
        $model->file = $file_name;
        $model->slug = $file_hash;
        $model->ext = $file->extension;
        $model->folder = $folderPath;
        $model->domain = getenv('STATIC_URL');
        $model->path = $basePath;
        $model->size = $file->size;
        $model->status = 998;

        if ($model->save()) {
            $this->copy_files($source, $basePath);
        }
        return $model;
    }

    function copy_files($source, $res)
    {
        $i = 0;
        if ($handle = opendir($source)) {
            /* Именно такой способ чтения элементов каталога является правильным. */
            while (false !== ($entry = readdir($handle))) {
                if ($entry != "." && $entry != "..") {
                    echo $i . " ---- " .$entry."<br/>";
                    copy($source.$entry, $res.$entry);
                    $i++;
                }
            }
            closedir($handle);
        }
    }

    public function clearOldDatA()
    {
        Files::deleteAll(['status' => 999]);
    }


}
