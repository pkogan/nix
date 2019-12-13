<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Balneario */

$this->title = 'Create Balneario';
$this->params['breadcrumbs'][] = ['label' => 'Balnearios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="balneario-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
