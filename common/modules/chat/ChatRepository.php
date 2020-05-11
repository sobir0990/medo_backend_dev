<?php

namespace common\modules\chat;

use common\models\Chat;
use common\models\Company;
use common\models\CompanyReviews;
use common\models\Message;
use common\models\Review;
use common\models\User;
use Yii;
use yii\web\NotFoundHttpException;

class ChatRepository
{

    public function createReview($id)
    {
        $company = Company::findOne($id);
        if ($company === null) {
            throw new NotFoundHttpException('Company not found');
        }

        $post = Yii::$app->request->post();
        $model = new Review();
        $user = User::authorize();
        if ($model->load($post, '')) {
            $model->profile_id = $user->profile->id;;
            $model->company_id = $id;
            $model->status = Review::STATUS_WAITING;
            if (!$model->save()) {
                Yii::$app->response->setStatusCode(422);
            }
            $this->_saveRelationReview($company, $model);
            return $model;
        }
    }

    private function _saveRelationReview($company, $model)
    {
        $review = new CompanyReviews();
        $review->company_id = $company->id;
        $review->review_id = $model->id;
        $review->save();
    }

    public function chatValidator($company_id){
        $profile = Yii::$app->user->identity->profile;
        $chat = Chat::find()
            ->andWhere(['chat.company_id' => $company_id, 'profile.id' => $profile->id])->exists();
        if ($chat) {
            return true;
        }
        return $this->addError('You\'ve already sent a message');
    }



}
