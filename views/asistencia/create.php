<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Asistencia */

$this->title = 'Create Asistencia';
$this->params['breadcrumbs'][] = ['label' => 'Asistencias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="asistencia-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
