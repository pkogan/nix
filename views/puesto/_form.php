<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Puesto */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="puesto-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'Nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model,'idBalneario')->dropDownList(yii\helpers\ArrayHelper::map(\app\models\Balneario::find()->all(),'idBalneario','Nombre')) ?>

    <?=  $form->field($model, 'latitude')->textInput() ?>
    <?=  $form->field($model, 'longitude')->textInput() ?>
    
    <?php   //echo  $form->field($model, 'Lugar')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
