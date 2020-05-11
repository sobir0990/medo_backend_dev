<?php
/**
 * Created by PhpStorm.
 * User: Utkir
 * Date: 20-Dec-17
 * Time: 19:00
 */

namespace backend\models;

use Yii;
use yii\base\ErrorException;
use yii\base\Model;
use yii\db\Exception;

class ReviewListFrom extends Model
{
    public $title;
    public $message;
    public $review_id;
    public $reason_id;
    const STATUS_NEW = 0;
    const STATUS_READ = 1;

    public function rules()
    {
        return [
            [['review_id','reason_id'], 'safe'],
            [['message','title'], 'safe'],


            [['review_id', 'title','message'], 'required', 'when' => function ($model) {
                $validate = empty($model->reason_id) && empty($model->title);
                if ($validate) { return false; }
                return true;
            }, 'whenClient' => "function (attribute, value) {
    if($('#bloglistfrom-review_id').val() == '' && $('#bloglistfrom-title').val() == ''){
    $('.field-bloglistfrom-review_id, .field-bloglistfrom-title').addClass( 'has-error' ).find('.help-block-error').text( 'Birini tanalang yoki Sabab yaratishga o`tib yangi sabab yarating!');
    return true;
    } else { 
    $('.field-bloglistfrom-review_id, .field-bloglistfrom-title').removeClass( 'has-error' ).find('.help-block-error').text('');
    return false;
    }
   }", 'message' => 'Birini tanalang yoki Sabab yaratishga o`tib yangi sabab yarating!'],
        ];
    }


}