<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AsistenciaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="asistencia-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'idAsistencia') ?>

    <?= $form->field($model, 'idGuardavidas') ?>

    <?= $form->field($model, 'Fecha') ?>

    <?= $form->field($model, 'idTipo') ?>

    <?= $form->field($model, 'idEstadoAsistencia') ?>

    <?php // echo $form->field($model, 'Lugar') ?>

    <?php // echo $form->field($model, 'Observacion') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
