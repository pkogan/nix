<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\daterange\DateRangePicker;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AsistenciaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Asistencias';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="asistencia-index">

    <h1><?= Html::encode($this->title) ?></h1>

<!--    <p>
    <?= Html::a('Create Asistencia', ['create'], ['class' => 'btn btn-success']) ?>
    </p>-->

    <?php Pjax::begin(); ?>
    <?php //echo $this->render('_search', ['model' => $searchModel]);  ?>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function ($model, $index, $widget, $grid) {

            return [
                'id' => $model['idAsistencia'],
                'onclick' => 'location.href="'
                . Yii::$app->urlManager->createUrl('asistencia/view')
                . '&id="+(this.id);'
            ];
        },
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
               // ['label' => 'id', 'attribute' => 'idAsistencia'],
            //'idAsistencia',
            ['label' => 'Guardavidas', 'attribute' => 'guardavidas', 'value' => 'idGuardavidas0.Nombre'],
                ['label' => 'Fecha', 'attribute' => 'dealerAvailableDate',
                'value' => 'fechaStr',
                //'format' => 'date',
                'filter' => DateRangePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'dealerAvailableDate',
                    'convertFormat' => true,
                    'pluginOptions' => [
                        'locale' => [
                            'format' => 'Y-m-d'
                        ],
                    ],
                ]),
            ],
                ['label' => 'Tipo', 'attribute' => 'tipo', 'value' => 'idTipo0.Descripcion'],
                ['label' => 'Puesto', 'attribute' => 'puesto', 'value' => 'idPuesto0.Nombre'],
                ['label' => 'Victimas', 'attribute' => 'victimas', 'value' => 'victimasCount'],
        //['label' => 'Estado','attribute' => 'idEstadoAsistencia0.Descripcion'],
        //'Lugar',
        //'Observacion:ntext',
        //['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    ?>

    <?php Pjax::end(); ?>

</div>
