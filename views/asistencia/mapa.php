<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $asistencias[] app\models\Asistencia */
use dosamigos\leaflet\types\LatLng;
use dosamigos\leaflet\layers\Marker;
use dosamigos\leaflet\layers\TileLayer;
use dosamigos\leaflet\LeafLet;
use dosamigos\leaflet\widgets\Map;

// first lets setup the center of our map
//print_r($asistencias);
// The Tile Layer (very important)
$markers = [];
foreach ($asistencias as $asistencia) {
    if (!is_null($asistencia->latitude)) {
        $center = new LatLng(['lat' => $asistencia->latitude, 'lng' => $asistencia->longitude]);

// now lets create a marker that we are going to place on our map
        $descripcion='<a href="'.Yii::$app->urlManager->createUrl('asistencia/view'). '&id='.$asistencia->idAsistencia.'">#'.$asistencia->idTipo0->Descripcion. ' '.$asistencia->Fecha.'</a>';
        $marker = new Marker(['latLng' => $center, 'popupContent' => $descripcion
         ]);
        $markers[] = $marker; // add the marker (addLayer is used to add different layers to our map)
    }
}

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

foreach ($markers as $marker) {
    $leaflet->addLayer($marker);
}


// finally render the widget
// we could also do
// echo $leaflet->widget();


$this->title = 'Mapa';
$this->params['breadcrumbs'][] = ['label' => 'Asistencias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="asistencia-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <?php echo Map::widget(['leafLet' => $leaflet]); ?>


</div>
