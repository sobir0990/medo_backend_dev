<?php

namespace common\components;

use common\models\Language;
use common\models\Menu;
use common\models\Settings;
use yii\base\Component;
use yii\helpers\ArrayHelper;
use Yii;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;
use backend\controllers\BackendController;

class Config extends Component
{
    public function init()
    {
        self::$_configurations = self::setConfigs();
        self::getSharedPaths();
        parent::init();
    }

    private static function setConfigs($lang = false)
    {
        $lang = $lang ?: Yii::$app->language;

        $language = Language::get($lang);

        $settings = Settings::getAll($language->id);

        return count($settings) ? ArrayHelper::map($settings, 'path', 'value') : [];
    }

    protected static $_configurations = [];

    public static function get($path = false, $lang = false)
    {
        $lang = $lang ?: Yii::$app->language;

        $language = Language::get($lang);
        $settings = Settings::get($path, $language->id);

        if ($settings instanceof Settings) {
            return $settings->value;
        }

        $settings = Settings::get($path);

        if ($settings instanceof Settings) {
            return $settings->value;
        }

        return '';
    }


    const HOME_PAGE_TITLE = 'home_page_title';
    const HOME_PAGE_LOGO = 'home_page_logo';
    const HOME_PAGE_DESCRIPTION = 'home_page_description';
    const HEADER_MENU = 'header_menu';
    const FOOTER_MENU = 'footer_menu';
    const HOME_ADDRESS = 'home_address';
    const HOME_ABOUT_PHONE = 'home_about_phone';
    const HOME_ABOUT_PHONES = 'home_about_phones';
    const HOME_ABOUT_TEXT = 'home_about_text';
    const HOME_ABOUT_EMAIL = 'home_about_email';
    const HOME_ABOUT_TELEGRAM = 'home_about_telegram';
    const HOME_ABOUT_FACEBOOK = 'home_about_facebook';
    const HOME_ABOUT_INSTA = 'home_about_insta';
    const HOME_ABOUT_VK = 'home_about_vk';

    public static function getAllConfiguration()
    {
        return [
            __('Home page settings') => [
                [
                    'label' => __('Home page title'),
                    'path' => self::HOME_PAGE_TITLE,
                    'type' => 'text',
                    'help' => __('Enter home page title'),
                ],
                [
                    'label' => __('Home page description'),
                    'path' => self::HOME_PAGE_DESCRIPTION,
                    'type' => 'textarea',
                    'help' => __('Enter home page description'),
                ],
                [
                    'label' => __('Home page logo'),
                    'path' => self::HOME_PAGE_LOGO,
                    'type' => 'file',
                    'help' => __('Enter home page logo'),
                ],
                [
                    'label' => __('Header menu'),
                    'path' => self::HEADER_MENU,
                    'type' => 'select',
                    'options' => Menu::getAll() ? ArrayHelper::map(Menu::getAll(), 'id', 'title') : [],
                    'help' => __('Select header menu'),
                ],
                [
                    'label' => __('Footer menu'),
                    'path' => self::FOOTER_MENU,
                    'type' => 'select',
                    'options' => Menu::getAll() ? ArrayHelper::map(Menu::getAll(), 'id', 'title') : [],
                    'help' => __('Select footer menu'),
                ],
                [
                    'label' => __('Address'),
                    'path' => self::HOME_ADDRESS,
                    'type' => 'text',
                    'help' => __('Address'),
                ],
                [
                    'label' => __('Home page phone'),
                    'path' => self::HOME_ABOUT_PHONE,
                    'type' => 'text',
                    'help' => __('Enter home page phone'),
                ],
                [
                    'label' => __('Home page second phone'),
                    'path' => self::HOME_ABOUT_PHONES,
                    'type' => 'text',
                    'help' => __('Enter home page phone'),
                ],
                [
                    'label' => __('Home page email'),
                    'path' => self::HOME_ABOUT_EMAIL,
                    'type' => 'text',
                    'help' => __('Enter home page email'),
                ],
            ],
            __('Social icons') => [
                [
                    'label' => __('Facebook'),
                    'path' => self::HOME_ABOUT_FACEBOOK,
                    'type' => 'text',
                    'help' => __('Social icons'),
                ],
                [
                    'label' => __('Instagram'),
                    'path' => self::HOME_ABOUT_INSTA,
                    'type' => 'text',
                    'help' => __('Social icons'),
                ],
                [
                    'label' => __('Vk'),
                    'path' => self::HOME_ABOUT_VK,
                    'type' => 'text',
                    'help' => __('Social icons'),
                ],
                [
                    'label' => __('Telegram'),
                    'path' => self::HOME_ABOUT_TELEGRAM,
                    'type' => 'text',
                    'help' => __('Social icons'),
                ],
            ],
        ];
    }

    public static $_sharedPaths;

    public static function getSharedPaths()
    {
        if (!self::$_sharedPaths) {
            $paths = self::getAllConfiguration();
            $result = [];

            foreach ($paths as $items) {
                foreach ($items as $item) {
                    $result[$item['path']] = $item['type'];
                }
            }

            self::$_sharedPaths = $result;
        }

        return self::$_sharedPaths;
    }

    public static function batchUpdate($configuration = [], $lang = false)
    {
        $paths = self::getSharedPaths();

        if (count($configuration)) {
            $image = UploadedFile::getInstanceByName('home_page_logo');

            if ($image)
                $configuration['home_page_logo'] = self::saveImage($image);

            foreach ($configuration as $path => $value) {
                if (array_key_exists($path, $paths)) {
                    $lang = $lang ?: Yii::$app->language;

                    $language = Language::get($lang);

                    $settings = Settings::get($path, $language->id);


                    if ($settings instanceof Settings) {
                        $settings->value = $value;

                        $settings->save();

                    } else {

                        $new = new Settings([
                            'path' => $path,
                            'value' => $value,
                            'language' => $language->id,
                        ]);

                        $new->save();
                    }
                }
            }

            self::afterConfigChange();
        }
    }

    public static function afterConfigChange()
    {
        self::$_configurations = self::setConfigs();
    }

    public static function saveImage($FILE, $POST_TYPE = 'settings', $CROP_LARGE = true)
    {
        if (!empty($FILE)) {
            $EXT = $FILE->extension == 'php' || $FILE->extension == 'js' ? 'file' : $FILE->extension;

            $DIR = realpath(dirname(__FILE__)) . '/../../static/' . $POST_TYPE . '/';
            $FILENAME = md5(time() . Yii::$app->user->id . $FILE->name . rand(1, 1000000) . rand(1, 1000000)) . '.' . $EXT;

            FileHelper::createDirectory($DIR);


            if ($FILE->saveAs($DIR . 'l_' . $FILENAME)) {
                $image = new ImageResize($DIR . 'l_' . $FILENAME);

                if ($CROP_LARGE == true) {
                    $image
                        ->resizeToBestFit(1900, 1080)
                        ->save($DIR . 'l_' . $FILENAME);
                }

                $image
                    ->resizeToWidth(800)
                    ->save($DIR . 'm_' . $FILENAME)
                    ->crop(350, 350)
                    ->save($DIR . 's_' . $FILENAME);

                return $FILENAME;
            }
        }

        return '';
    }

    public static function isImageExists($type, $size = 'm')
    {
        $size = in_array($size, ['s', 'm', 'l']) ? $size : '';

        if (!isset($type) && $type === NULL)
            return false;

        if (file_exists(Yii::getAlias('@static') . '/settings/' . '/' . $size . '_' . $type))
            return true;

        return false;

    }

    public static function getImageUrl($type, $size = 's')
    {
        $size = in_array($size, ['s', 'm', 'l']) ? $size : '';

        if (self::isImageExists($type, $size)) {
            return Yii::getAlias('@staticUrl') . '/settings/' . $size . '_' . $type;
        }

        return false;
    }
}