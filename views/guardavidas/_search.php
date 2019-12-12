<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\GuardavidasSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="guardavidas-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'idGuardavidas') ?>

    <?= $form->field($model, 'Nombre') ?>

    <?= $form->field($model, 'idRol') ?>

    <?= $form->field($model, 'idTelegram') ?>

    <?= $form->field($model, 'Mail') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
