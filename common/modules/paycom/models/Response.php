<?php
/**
 * @author Izzat <i.rakhmatov@list.ru>
 * @package advanced
 */

namespace common\modules\paycom\models;


use common\modules\paycom\exceptions\PaycomException;

class Response
{

    public $request;

    /**
     * Response constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param $result
     * @param null $error
     * @return \yii\web\Response
     */
    public function send($result, $error = null) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return \Yii::$app->controller->asJson(array(
            'jsonrpc' => '2.0',
            'id' => $this->request->id,
            'result' => $result,
            'error' => $error
        ));
    }

    /**
     * @param $code
     * @param null $message
     * @param null $data
     * @throws PaycomException
     */
    public function error($code, $message = null, $data = null) {
        throw new PaycomException($this->request->id, $message, $code, $data);
    }
}