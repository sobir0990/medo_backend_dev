<?php
/**
 * @author Izzat <i.rakhmatov@list.ru>
 */

namespace common\behaviors;


use common\modules\gallery\models\Gallery;
use frontend\widgets\SliderWidget;
use yii\base\Behavior;
use yii\db\ActiveRecord;

class GalleryBehavior extends Behavior
{

    public $attribute = 'gallery';

    const GALLERY_PATTERN = '/\[gallery id=(?P<id>\d+) type=(?P<type>\w+)\]/';

    public function events()
    {
        return array(
            ActiveRecord::EVENT_AFTER_FIND => 'afterFind'
        );
    }

    public function afterFind()
    {
        $model = $this->owner;

        $matches = array();
        preg_match_all(self::GALLERY_PATTERN, $model->description, $matches);
//        $model->description = preg_replace(self::GALLERY_PATTERN, "[gallery id='{$matches['id'][0]}'][/gallery]", $model->description);

        $galleries = array();

        $model->{$this->attribute} = array();

        foreach ($matches["id"] as $id) {
            $galleries[] = Gallery::findOne($id);
        }

        $this->owner->{$this->attribute} = $galleries;

    }

    public function getFormedDescription()
    {
        $model = $this->owner;

        $matches = array();
        preg_match_all(self::GALLERY_PATTERN, $model->description, $matches);

        foreach ($matches["id"] as $id) {
            $gallery = Gallery::findOne($id);
            $model->description = str_replace("[gallery id=$id type=oval]", $this->convertGalleryToHtml($gallery), $model->description);
        }

        return $model->description;

    }

    private function convertGalleryToHtml(Gallery $gallery)
    {
        $html = <<<HTML
            <div class="slider-carousel">
                <div class="slider-new-layout layout--2">
                    <div class="items owl-carousel owl-theme">
HTML;
        $items = $gallery->getFiles()->all();
        foreach ($items as $model):
            $html .= '<a href="#" class="item">
                        <img src="' . $model->src . '" alt="">
                        <div class="title">' . $model->title . '</div>
                       </a>';
        endforeach;
        $html .= <<<HTML
                    </div>
                </div>
            </div>
HTML;

        return $html;

    }


}