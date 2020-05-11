<?php
/**
 * @author Izzat <i.rakhmatov@list.ru>
 * @package advanced
 */

namespace common\modules\paycom\controllers;


use common\models\User;
use common\modules\paycom\dto\PaymentHistoryDTO;
use common\modules\paycom\exceptions\PaycomException;
use common\modules\paycom\models\PaymentHistory;
use common\modules\paycom\models\Request;
use common\modules\paycom\models\Response;
use common\modules\paycom\models\Transaction;
use yii\rest\Controller;

class DefaultController extends Controller
{

    public $request;

    public $response;
    /**
     * @var array
     */
    private $config;

    /**
     * DefaultController constructor.
     * @param $id
     * @param $module
     * @param array $config
     * @throws PaycomException
     */
    public function __construct($id, $module, $config = [])
    {
        $this->request = new Request();
        $this->response = new Response($this->request);
        $this->id = $id;
        $this->module = $module;
        $this->config = $config;
    }

    /**
     * @param $request_id
     * @throws PaycomException
     */
    public function authorize()
    {
        if (
            !\Yii::$app->request->getHeaders()->get('Authorization')
            || !preg_match('/^s*Basic\s+(\S+)\s*$/i', \Yii::$app->request->getHeaders()->get('Authorization'), $matches)
            || base64_decode($matches[1]) != \Yii::$app->params['paycom']['login'] . ":" . \Yii::$app->params['paycom']['test_key']
        ) {
            throw new PaycomException(
                $this->request->id,
                'Insufficient privilege to perform this method.',
                PaycomException::ERROR_INSUFFICIENT_PRIVILEGE
            );
        }

        return true;
    }

    /**
     * @throws PaycomException
     */
    public function actionIndex()
    {

        if (
            !\Yii::$app->request->getHeaders()->get('Authorization')
            || !preg_match('/^s*Basic\s+(\S+)\s*$/i', \Yii::$app->request->getHeaders()->get('Authorization'), $matches)
            || base64_decode($matches[1]) != \Yii::$app->params['paycom']['login'] . ":" . file_get_contents(\Yii::getAlias('@common/../.paycom_key'))
        ) {
            return $this->asJson(new PaycomException(
                $this->request->id,
                'Insufficient privilege to perform this method.',
                PaycomException::ERROR_INSUFFICIENT_PRIVILEGE
            ));
        }

        try {
            switch ($this->request->data['method']) {
                case 'CheckPerformTransaction':
                    $this->checkPerformTransaction();
                    break;
                case 'CheckTransaction':
                    $this->checkTransaction();
                    break;
                case 'CreateTransaction':
                    $this->createTransaction();
                    break;
                case 'PerformTransaction':
                    $this->performTransaction();
                    break;
                case 'CancelTransaction':
                    $this->cancelTransaction();
                    break;
                case 'ChangePassword':
                    $this->changePassword();
                    break;
                case 'GetStatement':
                    $this->getStatement();
                    break;
                default:
                    $this->response->error(
                        PaycomException::ERROR_METHOD_NOT_FOUND,
                        'Method not found.',
                        $this->request->data['method']
                    );
                    break;
            }
        } catch (PaycomException $e) {
            return $this->asJson($e->getError());
        }
    }

    private function checkPerformTransaction()
    {

        $transaction = Transaction::find()->where([
            'transaction_id' => $this->request->id,
            'user_id' => $this->request->data['params']['account']['user_id']
        ])->one();

        if ($transaction instanceof Transaction) {
            $this->response->error(
                PaycomException::ERROR_COULD_NOT_PERFORM,
                'There is other active/complated transaction for this order.'
            );
        }

        $this->response->send(['allow' => true]);


    }

    /**
     * @throws PaycomException
     */
    private function checkTransaction()
    {
        if (array_key_exists('account', $this->request->data['params'])
            && array_key_exists('user_id', $this->request->data['params']['account'])
        ) {
            $transaction = Transaction::find()->where([
                'user_id' => $this->request->data['params']['account']['user_id'],
                'state' => array(Transaction::STATE_CREATED, Transaction::STATE_COMPLETED)
            ])->one();
        } elseif (array_key_exists('id', $this->request->data['params'])) {
            $transaction = Transaction::find()->where([
                'transaction_id' => $this->request->data['params']['id']
            ])->one();
        } else {
            throw new PaycomException(
                $this->request->id,
                'Parameter to find a transaction is not specified.',
                PaycomException::ERROR_INTERNAL_SYSTEM
            );
        }

        if (!$transaction instanceof Transaction) {
            $this->response->error(
                PaycomException::ERROR_TRANSACTION_NOT_FOUND,
                'Transaction not found.'
            );
        }

        $this->response->send([
            'create_time' => $transaction->created_at * 1000,
            'perform_time' => $transaction->perform_at * 1000,
            'cancel_time' => $transaction->cancel_at * 1000,
            'transaction' => strval($transaction->id),
            'state' => $transaction->state,
            'reason' => $transaction->reason
        ]);

    }

    /**
     * @throws PaycomException
     */
    private function createTransaction()
    {

        if (array_key_exists('id', $this->request->data['params'])) {
            $transaction = Transaction::find()->where([
                'transaction_id' => $this->request->data['params']['id']
            ])->one();
        } elseif (array_key_exists('account', $this->request->data['params'])
            && array_key_exists('user_id', $this->request->data['params']['account'])
        ) {
            $transaction = Transaction::find()->where([
                'user_id' => $this->request->data['params']['account']['user_id'],
                'state' => array(Transaction::STATE_CREATED, Transaction::STATE_COMPLETED)
            ])->one();
        } else {
            throw new PaycomException(
                $this->request->id,
                'Parameter to find a transaction is not specified.',
                PaycomException::ERROR_INTERNAL_SYSTEM
            );
        }

        if ($transaction instanceof Transaction) {
            if ($transaction->state != Transaction::STATE_CREATED) {
                $this->response->error(
                    PaycomException::ERROR_COULD_NOT_PERFORM,
                    'Transaction found, but not active.'
                );
            } elseif ($transaction->isExpired()) {
                $transaction->cancel(Transaction::REASON_CANCELLED_BY_TIMEOUT);
                $this->response->error(
                    PaycomException::ERROR_COULD_NOT_PERFORM,
                    'Transaction is expired.'
                );
            } else {
                $this->response->send([
                    'create_time' => $transaction->created_at * 1000,
                    'transaction' => strval($transaction->id),
                    'state' => $transaction->state,
                    'receivers' => null
                ]);
            }
        } else {
            if (intval($this->request->data['params']['time']) - time() * 1000 >= Transaction::TIMEOUT) {
                $this->response->error(
                    PaycomException::ERROR_INVALID_ACCOUNT,
                    PaycomException::message(
                        'С даты создания транзакции прошло ' . Transaction::TIMEOUT . 'мс',
                        'Tranzaksiya yaratilgan sanadan ' . Transaction::TIMEOUT . 'ms o`tdi',
                        'Since create time of the transaction passed' . Transaction::TIMEOUT . 'ms'
                    ),
                    'time'
                );
            }

            $transaction = new Transaction();
            $transaction->transaction_id = $this->request->data['params']['id'];
            $transaction->time = $this->request->data['params']['time'];
            $transaction->state = Transaction::STATE_CREATED;
            $transaction->amount = $this->request->data['params']['amount'];
            $transaction->user_id = $this->request->data['params']['account']['user_id'];
            $transaction->save();

            $this->response->send([
                'create_time' => $transaction->created_at * 1000,
                'transaction' => strval($transaction->id),
                'state' => $transaction->state,
                'receivers' => null
            ]);
        }


    }

    private function performTransaction()
    {
        if (array_key_exists('account', $this->request->data['params'])
            && array_key_exists('user_id', $this->request->data['params']['account'])
        ) {
            $transaction = Transaction::find()->where([
                'user_id' => $this->request->data['params']['account']['user_id'],
                'state' => array(Transaction::STATE_CREATED, Transaction::STATE_COMPLETED)
            ])->one();
        } elseif (array_key_exists('id', $this->request->data['params'])) {
            $transaction = Transaction::find()->where([
                'transaction_id' => $this->request->data['params']['id']
            ])->one();
        } else {
            throw new PaycomException(
                $this->request->id,
                'Parameter to find a transaction is not specified.',
                PaycomException::ERROR_INTERNAL_SYSTEM
            );
        }

        if (!$transaction instanceof Transaction) {
            $this->response->error(
                PaycomException::ERROR_TRANSACTION_NOT_FOUND,
                'Transaction not found.'
            );
        }

        switch ($transaction->state) {
            case Transaction::STATE_CREATED:
                if ($transaction->isExpired()) {
                    $transaction->cancel(Transaction::REASON_CANCELLED_BY_TIMEOUT);
                    $this->response->error(
                        PaycomException::ERROR_COULD_NOT_PERFORM,
                        'Transaction is expired.'
                    );
                } else {
                    $transaction->state = Transaction::STATE_COMPLETED;
                    $transaction->perform_at = time();
                    $transaction->save();

                    PaymentHistory::add(new PaymentHistoryDTO([
                        'user_id' => $transaction->user_id,
                        'payment_type' => PaymentHistory::PAYMENT_TYPE_PAYCOM,
                        'amount' => $transaction->amount / 100,
                        'transaction_id' => $transaction->id,
                    ]));
                }

                $this->response->send([
                    'transaction' => strval($transaction->id),
                    'perform_time' => $transaction->perform_at * 1000,
                    'state' => $transaction->state
                ]);

                break;
            case Transaction::STATE_COMPLETED:
                $this->response->send([
                    'transaction' => strval($transaction->id),
                    'perform_time' => $transaction->perform_at * 1000,
                    'state' => $transaction->state
                ]);

                break;
            default:
                $this->response->error(
                    PaycomException::ERROR_COULD_NOT_PERFORM,
                    'Coult not perform this operation.'
                );
                break;
        }

    }

    /**
     * @throws PaycomException
     */
    private function cancelTransaction()
    {
        if (array_key_exists('account', $this->request->data['params'])
            && array_key_exists('user_id', $this->request->data['params']['account'])
        ) {
            $transaction = Transaction::find()->where([
                'user_id' => $this->request->data['params']['account']['user_id'],
                'state' => array(Transaction::STATE_CREATED, Transaction::STATE_COMPLETED)
            ])->one();
        } elseif (array_key_exists('id', $this->request->data['params'])) {
            $transaction = Transaction::find()->where([
                'transaction_id' => $this->request->data['params']['id']
            ])->one();
        } else {
            throw new PaycomException(
                $this->request->id,
                'Parameter to find a transaction is not specified.',
                PaycomException::ERROR_INTERNAL_SYSTEM
            );
        }

        if (!$transaction instanceof Transaction) {
            $this->response->error(
                PaycomException::ERROR_TRANSACTION_NOT_FOUND,
                'Transaction not found.'
            );
        }

        switch ($transaction->state) {
            case Transaction::STATE_CANCELLED:
            case Transaction::STATE_CANCELLED_AFTER_COMPLETE:
                $this->response->send([
                    'transaction' => strval($transaction->id),
                    'cancel_time' => $transaction->cancel_at * 1000,
                    'state' => $transaction->state
                ]);

                break;
            case Transaction::STATE_CREATED:
                $transaction->cancel(intval($this->request->data['params']['reason']));

                $this->response->send([
                    'transaction' => strval($transaction->id),
                    'cancel_time' => $transaction->cancel_at * 1000,
                    'state' => $transaction->state
                ]);

                break;
            case Transaction::STATE_COMPLETED:
                if (User::getBalanceByUserId($transaction->user_id) >= ($transaction->amount / 100)) {
                    $transaction->cancel(intval($this->request->data['params']['reason']));

                    PaymentHistory::add(new PaymentHistoryDTO([
                        'user_id' => $transaction->user_id,
                        'payment_type' => PaymentHistory::PAYMENT_CANCELLED_TYPE_PAYCOM,
                        'amount' => -($transaction->amount / 100),
                        'transaction_id' => $transaction->id,
                    ]));

                    $this->response->send([
                        'transaction' => strval($transaction->id),
                        'cancel_time' => $transaction->cancel_at * 1000,
                        'state' => $transaction->state
                    ]);

                } else {
                    $this->response->error(
                        PaycomException::ERROR_COULD_NOT_CANCEL,
                        'Coult not cancel transaction. Order is delivered/Service is completed.'
                    );
                }

                break;
        }
    }


    private function changePassword()
    {

        if (!array_key_exists('password', $this->request->data['params'])
            || !trim($this->request->data['params']['password'])
        ) {
            $this->response->error(
                PaycomException::ERROR_INVALID_ACCOUNT,
                'New password not specified.',
                'password'
            );
        }

        if (file_get_contents(\Yii::getAlias('@common/../.paycom_key')) == $this->request->data['params']['password']) {
            $this->response->error(
                PaycomException::ERROR_INSUFFICIENT_PRIVILEGE,
                'Insufficient privilege. Incorrect new password.'
            );
        }

        if (!file_put_contents(\Yii::getAlias('@common/../.paycom_key'), $this->request->data['params']['password'])) {
            $this->response->error(
                PaycomException::ERROR_INTERNAL_SYSTEM,
                'Internal System Error.'
            );
        }

        $this->response->send(['success' => true]);
    }

    private function getStatement()
    {
        $this->response->error(
            PaycomException::ERROR_INTERNAL_SYSTEM,
            'Internal System Error.'
        );
    }
}