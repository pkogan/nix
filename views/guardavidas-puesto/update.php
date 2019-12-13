<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\GuardavidasPuesto */

$this->title = 'Update Guardavidas Puesto: ' . $model->idGuardavidasPuesto;
$this->params['breadcrumbs'][] = ['label' => 'Guardavidas Puestos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idGuardavidasPuesto, 'url' => ['view', 'id' => $model->idGuardavidasPuesto]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="guardavidas-puesto-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
