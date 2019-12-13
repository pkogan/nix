<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\GuardavidasPuestoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Guardavidas Puestos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="guardavidas-puesto-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Guardavidas Puesto', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'idGuardavidasPuesto',
            ['label' => 'Guardavidas', 'attribute' => 'guardavidas', 'value' => 'idGuardavidas0.Nombre'],
            //'idGuardavidas0.Nombre:text:Guardavidas',
            ['label' => 'Balneario', 'attribute' => 'balneario', 'value' => 'idPuesto0.idBalneario0.Nombre'],
            //'idPuesto0.idBalneario0.Nombre:text:Balneario',
            'idPuesto0.Nombre:text:Puesto',
            
            'Fecha',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
