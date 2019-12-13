<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Balneario */

$this->title = 'Update Balneario: ' . $model->idBalneario;
$this->params['breadcrumbs'][] = ['label' => 'Balnearios', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idBalneario, 'url' => ['view', 'id' => $model->idBalneario]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="balneario-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
