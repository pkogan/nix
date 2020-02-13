<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Puesto */
use dosamigos\leaflet\types\LatLng;
use dosamigos\leaflet\layers\Marker;
use dosamigos\leaflet\layers\TileLayer;
use dosamigos\leaflet\LeafLet;
use dosamigos\leaflet\widgets\Map;

$this->title = $model->idPuesto;
$this->params['breadcrumbs'][] = ['label' => 'Puestos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$center = new LatLng(['lat' => $model->latitude, 'lng' => $model->longitude]);

// now lets create a marker that we are going to place on our map
$descripcion = '<a href="' . Yii::$app->urlManager->createUrl('puesto/view') . '&id=' . $model->idPuesto . '">#' . $model->Nombre . '</a>';
$marker = new Marker(['latLng' => $center, 'popupContent' => $descripcion]);
$tileLayer = new TileLayer([
    'urlTemplate' => 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
    'clientOptions' => [
        'attribution' => '' .
        'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>',
    //'subdomains' => 'nix'
    ]
        ]);
$leaflet = new LeafLet([
    'tileLayer' => $tileLayer, // set the TileLayer
    'center' => $center, // set the center
        ]);
$leaflet->addLayer($marker);
?>
<div class="puesto-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->idPuesto], ['class' => 'btn btn-primary']) ?>
        <?=
        Html::a('Delete', ['delete', 'id' => $model->idPuesto], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ])
        ?>
    </p>

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'idPuesto',
            'Nombre',
            'idBalneario0.Nombre',
            'latitude',
            'longitude',
            //'Lugar',
        ],
    ])
    ?>
    <?php echo Map::widget(['leafLet' => $leaflet]);?>
</div>
