<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\GuardavidasPuesto */

$this->title = 'Create Guardavidas Puesto';
$this->params['breadcrumbs'][] = ['label' => 'Guardavidas Puestos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="guardavidas-puesto-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
