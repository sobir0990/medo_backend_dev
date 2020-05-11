<?php
/**
 * Created by PhpStorm.
 * User: Javharbek
 * Date: 22.02.2018
 * Time: 16:32
 */
echo $form->field($node, 'description')->textarea();

if($node->isRoot())
{
    $data = common\modules\categories\models\Categories::find()->allTypes();
    if($data == null){
        $data = [];
    }
    echo $form->field($node, 'type')->dropDownList($data);
}

echo $form->field($node, 'slug');