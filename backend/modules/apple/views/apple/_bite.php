<?php

use backend\models\forms\AppleBiteForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model AppleBiteForm */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="apple-bite-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'bitePercent')->textInput()->label('Сколько откусим?') ?>

    <?php if (!Yii::$app->request->isAjax) { ?>
        <div class="form-group">
            <?= Html::submitButton('Откусить') ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>

</div>
