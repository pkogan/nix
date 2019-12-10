<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Asistencia */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="asistencia-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'idGuardavidas')->textInput() ?>

    <?= $form->field($model, 'Fecha')->textInput() ?>

    <?= $form->field($model, 'idTipo')->textInput() ?>

    <?= $form->field($model, 'idEstadoAsistencia')->textInput() ?>

    <?= $form->field($model, 'Lugar')->textInput() ?>

    <?= $form->field($model, 'Observacion')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
