<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Puesto */

$this->title = 'Update Puesto: ' . $model->idPuesto;
$this->params['breadcrumbs'][] = ['label' => 'Puestos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idPuesto, 'url' => ['view', 'id' => $model->idPuesto]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="puesto-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
