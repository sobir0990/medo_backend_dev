<?php

use common\modules\translation\models\SourceMessageSearch;
use kartik\daterange\DateRangePicker;
use kartik\editable\Editable;
use kartik\select2\Select2;
use yii\data\ActiveDataProvider;
use yii\data\Sort;
use yii\helpers\Html;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\translations\models\SourceMessageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Source Messages';
$this->params['breadcrumbs'][] = $this->title;
$langs = \oks\langs\models\Langs::find()->all();
$sort = new Sort([
    'attributes' => [
        'message' => [
            'asc' => ['message' => SORT_ASC],
            'desc' => ['message' => SORT_DESC],
            'default' => SORT_DESC,
            'label' => 'Message',
        ],
    ],
]);
$sources = \common\modules\translation\models\SourceMessage::find();
$pages = new \yii\data\Pagination(['totalCount' => $sources->count(), 'pageSize' => 80, 'pageSizeParam' => false, 'forcePageParam' => false]);
$translate = $sources->offset($pages->offset)->limit($pages->limit)->all();
$s = 0;
?>
<style>
    .popover {
        display: none;
    }
</style>
<div class="dataTables_wrapper no-footer" id="basicTable_wrapper">
    <div class="panel">
        <div class="panel-heading">
            <h1><?= __('Translations') ?></h1>
            <p>
                <?= Html::a('Create', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
        </div>
        <div class="panel-body">

            <table class="table">
                <thead>
                <tr>
                    <td>#</td>
                    <td><?= $sort->link('message') ?></td>
                    <?php foreach ($langs as $lang): ?>
                        <td>
                            <?php echo $lang->name; ?>
                        </td>
                    <?php endforeach; ?>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($translate as $source): $messages = $source->messages; ?>
                    <?php $s++; ?>
                    <tr>
                        <td>
                            <?= $source->id ?>
                        </td>
                        <td>
                            <?= $source->message ?>
                        </td>
                        <?php foreach ($langs as $lang): ?>
                            <?php
                            $value_query = \common\modules\translation\models\Message::find()->where(['id' => $source->id])->andWhere(['language' => $lang->code]);
                            if ($value_query->count() == 0) {
                                $value_lang = $source->message;
                            } else {
                                $value_lang = $value_query->one()->translation;
                            }
                            ?>
                            <td>
                                <?php
                                echo Editable::widget([
                                    'name' => 'translation[' . $lang->code . '][' . $source->id . ']',
                                    'asPopover' => true,
                                    'value' => $value_lang,
                                    'header' => 'Name',
                                    'size' => 'md',
                                    'options' => ['class' => 'form-control', 'placeholder' => 'Enter person name...'],
                                    'additionalData' => ['hasEditable' => true]
                                ]);
                                ?>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <?= \yii\widgets\LinkPager::widget([
                    'pagination' => $pages,
                ]); ?>
        </div>
    </div>
</div>
