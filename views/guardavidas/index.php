<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\GuardavidasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Guardavidas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="guardavidas-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Guardavidas', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'idGuardavidas',
            'Nombre',

            ['label' => 'Rol', 'attribute' => 'rol', 'value' => 'idRol0.Descripcion'],
            //'idRol0.Descripcion',
            'idTelegram',
            'Mail',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>