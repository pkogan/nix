<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Guardavidas */

$this->title = 'Update Guardavidas: ' . $model->idGuardavidas;
$this->params['breadcrumbs'][] = ['label' => 'Guardavidas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idGuardavidas, 'url' => ['view', 'id' => $model->idGuardavidas]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="guardavidas-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
