<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Asistencia */

$this->title = 'Update Asistencia: ' . $model->idAsistencia;
$this->params['breadcrumbs'][] = ['label' => 'Asistencias', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idAsistencia, 'url' => ['view', 'id' => $model->idAsistencia]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="asistencia-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
