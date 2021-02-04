<?php

use backend\models\forms\AppleBiteForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \backend\models\forms\AppleGenerateForm */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="apple-bite-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'amount')->textInput()->label('Сколько яблок создадим?') ?>

    <?php if (!Yii::$app->request->isAjax) { ?>
        <div class="form-group">
            <?= Html::submitButton('Создать') ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>

</div>
