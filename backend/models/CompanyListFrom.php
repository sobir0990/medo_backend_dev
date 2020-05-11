<?php
/**
 * Created by PhpStorm.
 * User: Utkir
 * Date: 20-Dec-17
 * Time: 19:00
 */

namespace backend\models;


use common\models\Question;
use Yii;
use yii\base\ErrorException;
use yii\base\Model;
use yii\db\Exception;

class CompanyListFrom extends Model
{
    public $title;
    public $message;
    public $company_id;
    public $reason_id;
    const STATUS_NEW = 0;
    const STATUS_READ = 1;

    public function rules()
    {
        return [
            [['company_id','reason_id'], 'safe'],
            [['message','title'], 'safe'],


            [['company_id', 'title','message'], 'required', 'when' => function ($model) {
                $validate = empty($model->reason_id) && empty($model->title);
                if ($validate) { return false; }
                return true;
            }, 'whenClient' => "function (attribute, value) {
    if($('#bloglistfrom-company_id').val() == '' && $('#bloglistfrom-title').val() == ''){
    $('.field-bloglistfrom-company_id, .field-bloglistfrom-title').addClass( 'has-error' ).find('.help-block-error').text( 'Birini tanalang yoki Sabab yaratishga o`tib yangi sabab yarating!');
    return true;
    } else { 
    $('.field-bloglistfrom-company_id, .field-bloglistfrom-title').removeClass( 'has-error' ).find('.help-block-error').text('');
    return false;
    }
   }", 'message' => 'Birini tanalang yoki Sabab yaratishga o`tib yangi sabab yarating!'],
        ];
    }


}