<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Balneario */
use dosamigos\leaflet\types\LatLng;
use dosamigos\leaflet\layers\Marker;
use dosamigos\leaflet\layers\TileLayer;
use dosamigos\leaflet\LeafLet;
use dosamigos\leaflet\widgets\Map;


$this->title = $model->idBalneario;
$this->params['breadcrumbs'][] = ['label' => 'Balnearios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$markers = [];
foreach ($model->puestos as $puesto) {
    if (!is_null($puesto->latitude)) {
        $center = new LatLng(['lat' => $puesto->latitude, 'lng' => $puesto->longitude]);

// now lets create a marker that we are going to place on our map
        $descripcion = '<a href="' . Yii::$app->urlManager->createUrl('puesto/view') . '&id=' . $puesto->idPuesto . '">#' . $puesto->Nombre . '</a>';
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


?>
<div class="balneario-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->idBalneario], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->idBalneario], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'idBalneario',
            'Nombre',
            'Dirección',
        ],
    ]) ?>
    
     <?php 
    if (count($markers) > 0) {
    $leaflet = new LeafLet([
        'tileLayer' => $tileLayer, // set the TileLayer
        'center' => $center, // set the center
    ]);

    foreach ($markers as $marker) {
        $leaflet->addLayer($marker);
    }
    echo Map::widget(['leafLet' => $leaflet]);
} else{
    echo 'No tiene puntos para mostrar';
}
     ?>

</div>
