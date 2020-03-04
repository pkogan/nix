<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use dosamigos\leaflet\types\LatLng;
use dosamigos\leaflet\layers\Marker;
use dosamigos\leaflet\layers\TileLayer;
use dosamigos\leaflet\LeafLet;
use dosamigos\leaflet\widgets\Map;

/* @var $this yii\web\View */
/* @var $model app\models\Asistencia */


?>
<div class="asistencia-view">

    <h3><?= Html::a($model->getFechaStr().' #'.$model->idAsistencia.' '.$model->idTipo0->Descripcion, ['view', 'id' => $model->idAsistencia], []) ?></h3>

<!--    <p>
    <?= Html::a('Update', ['update', 'id' => $model->idAsistencia], ['class' => 'btn btn-primary']) ?>
    
    <?=
    Html::a('Delete', ['delete', 'id' => $model->idAsistencia], [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => 'Are you sure you want to delete this item?',
            'method' => 'post',
        ],
    ])
    ?>

    </p>-->

    <?php
    $atributes = [
        //'idAsistencia',
            [// the owner name of the model
            'label' => 'Guardavidas',
            'value' => $model->idGuardavidas0->Nombre,
        ],
        'Fecha',
        
            [// the owner name of the model
            'label' => 'Estado',
            'value' => $model->idEstadoAsistencia0->Descripcion,
        ],
        //'Lugar',
        //'latitude',
        //'longitude',
         
        //'Observacion:ntext',
    ];
    if(isset($model->latitude)){
        $atributes[] = 'latitude';
        $atributes[] = 'longitude';
        
    }
    if(isset($model->Observacion)){
        $atributes[] = 'Observacion:ntext';
        
        
    }
    if (isset($model->idPuesto)){
        $atributes[] = [// the owner name of the model
            'label' => 'Puesto',
            'value' => $model->idPuesto0->idBalneario0->Nombre.' Puesto '.$model->idPuesto0->Nombre,
        ];
    }
    if (count($model->victimas) > 0) {
        /*$victima = [];
        foreach ($model->victimas as $key => $value) {
            /* @var $value app\models\Victima */
            /*$victima[] = $value->Cantidad . ' ' . $value->idRangoEtario0->Descripcion;
        }*/
        $atributes[] = ['label' => 'Victimas', 'value' => $model->getVictimasStr()];
    }
    if (count($model->archivos) > 0) {
        $archivos = [];
        foreach ($model->archivos as $key => $value) {
            /* @var $value app\models\Archivo */
            $archivos[] = '<a href="'.$value->Path.'">archivo'.$key.'.'.substr($value->Path, strlen($value->Path)-3,3).'</a>';
            if(substr($value->Path, strlen($value->Path)-3,3)=='jpg'){
                $archivos[] = '<img src="'.$value->Path.'"/>';
            }
            
        }
        $atributes[] = ['label' => 'Adjuntos','format'=>'raw', 'value' => implode('<br/>', $archivos)];
    }
    if (count($model->asistenciaEquipamientos) > 0) {
        $equipamiento = [];
        foreach ($model->asistenciaEquipamientos as $key => $value) {
            /* @var $value app\models\AsistenciaEquipamiento */
            $equipamiento[] = $value->idEquipameinto0->Descripcion;
        }
        $atributes[] = ['label' => 'Equipamiento', 'value' => implode(', ', $equipamiento)];
    }
    
    
    if (in_array($model->idTipo, [app\models\Asistencia::TIPO_RESCATE, app\models\Asistencia::TIPO_PRIMEROSAUXILIOS])) {
        $atributes[] = ['label' => 'Complejidad', 'value' => $model->incidentes[0]->idComplejidad0->Descripcion];
        if (count($model->incidentes[0]->primerosAuxiliosIncidentes) > 0) {
            $incidente = [];
            foreach ($model->incidentes[0]->primerosAuxiliosIncidentes as $key => $value) {
                /* @var $value app\models\PrimerosAuxiliosIncidente */
                $incidente[] = $value->idPrimerosAuxilios0->Descripcion;
            }
            $atributes[] = ['label' => 'Primeros Auxilios', 'value' => implode(', ', $incidente)];
        }
    }
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $atributes
    ]);

    ?>

</div>
