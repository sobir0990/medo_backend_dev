<?php
/**
 * @author Izzat <i.rakhmatov@list.ru>
 * @package advanced
 */

namespace common\modules\paycom\dto;


use yii\base\Model;

class PaymentHistoryDTO extends Model
{
    public $user_id;
    public $payment_type;
    public $amount;
    public $description;
    public $transaction_id;
}