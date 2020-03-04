<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;
use kartik\daterange\DateRangePicker;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AsistenciaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Asistencias';
$this->params['breadcrumbs'][] = $this->title;

$this->registerJs("
$('.btn-search').click(function(){
    $('.search-form').toggle();
    return false;
});

");
?>
<div class="asistencia-index">

    <h1><?= Html::encode($this->title) ?></h1>

<!--    <p>
    <?= Html::a('Create Asistencia', ['create'], ['class' => 'btn btn-success']) ?>
    </p>-->


    <?php echo Html::a('Busqueda Avanzada','#',array('class'=>'btn-search btn btn-success')); ?>
<div class="search-form" style="display:none">
    <?php echo $this->render('_searchResumen', ['model' => $searchModel]);  ?>
</div>
        <?php Pjax::begin(); ?>
    <?=
    ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_view',
        
    ]);
    ?>

    <?php Pjax::end(); ?>

</div>
