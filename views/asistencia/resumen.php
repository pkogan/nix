<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\daterange\DateRangePicker;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AsistenciaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Resumen';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="asistencia-index">

    <h1><?= Html::encode($this->title) ?></h1>

<!--    <p>
    <?= Html::a('Create Asistencia', ['create'], ['class' => 'btn btn-success']) ?>
    </p>-->

    <?php Pjax::begin(); ?>
    <?php echo $this->render('_searchResumen', ['model' => $searchModel]);  ?>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
               // ['label' => 'id', 'attribute' => 'idAsistencia'],
            //'idAsistencia',
            //['label' => 'Guardavidas', 'attribute' => 'guardavidas', 'value' => 'idGuardavidas0.Nombre'],
                //'idTipo0.Descripcion',
                ['label' => 'Tipo',  'value' => 'Descripcion'],
                ['label' => 'Puesto',  'value' => 'Nombre'],
                ['label' => 'Asistencia', 'value' => 'Count'],
                ['label' => 'Victimas', 'value' => 'Cantidad'],
        //['label' => 'Estado','attribute' => 'idEstadoAsistencia0.Descripcion'],
        //'Lugar',
        //'Observacion:ntext',
        //['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    ?>

    <?php Pjax::end(); ?>

</div>
