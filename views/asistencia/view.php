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

$this->title = $model->idAsistencia;
$this->params['breadcrumbs'][] = ['label' => 'Asistencias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="asistencia-view">

    <h1><?= Html::encode($this->title) ?></h1>

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
<?php if(Yii::$app->user->identity->idRol== \app\models\Asistencia::ROL_ADMIN){
    echo Html::a('CrearPuesto', ['/puesto/creardesdeasistencia', 'id' => $model->idAsistencia], ['class' => 'btn btn-primary']);
} ?>
    <?php
    $atributes = [
        'idAsistencia',
            [// the owner name of the model
            'label' => 'Guardavidas',
            'value' => $model->idGuardavidas0->Nombre,
        ],
        'Fecha',
            [// the owner name of the model
            'label' => 'Tipo',
            'value' => $model->idTipo0->Descripcion,
        ],
            [// the owner name of the model
            'label' => 'Estado',
            'value' => $model->idEstadoAsistencia0->Descripcion,
        ],
        //'Lugar',
        'latitude',
        'longitude',
         
        'Observacion:ntext',
    ];
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
    if (!is_null($model->latitude)) {
        $center = new LatLng(['lat' => $model->latitude, 'lng' => $model->longitude]);
        $descripcion = '#' . $model->idTipo0->Descripcion . ' ' . $model->Fecha;
        $marker = new Marker(['latLng' => $center, 'popupContent' => $descripcion
        ]);
        $tileLayer = new TileLayer([
            'urlTemplate' => 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
            'clientOptions' => [
                'attribution' => '' .
                'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>',
            //'subdomains' => 'nix'
            ]
        ]);

// now our component and we are going to configure it
        $leaflet = new LeafLet([
            'tileLayer' => $tileLayer, // set the TileLayer
            'center' => $center, // set the center
        ]);


        $leaflet->addLayer($marker);
        echo Map::widget(['leafLet' => $leaflet]);
    }
    ?>

</div>
