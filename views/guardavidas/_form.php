<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Guardavidas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="guardavidas-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'Nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'idRol')->textInput() ?>

    <?= $form->field($model, 'idTelegram')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Mail')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
