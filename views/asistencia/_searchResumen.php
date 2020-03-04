<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Asistencia;

/* @var $this yii\web\View */
/* @var $model app\models\AsistenciaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="asistencia-search">

    <?php
    $form = ActiveForm::begin([
                'action' => [Yii::$app->controller->action->id],
                'method' => 'get',
                'options' => [
                    'data-pjax' => 1
                ],
    ]);
    ?>


    <?php
    if (Yii::$app->user->identity->idRol == \app\models\Asistencia::ROL_ADMIN) {
        $items = yii\helpers\ArrayHelper::map(\app\models\Guardavidas::find()->all(), 'idGuardavidas', 'Nombre');
    } else {
        $items = yii\helpers\ArrayHelper::map(\app\models\Guardavidas::find()->where('idGuardavidas in ' . \app\models\GuardavidasPuesto::companneros())->all(), 'idGuardavidas', 'Nombre');
    }
    echo $form->field($model, 'idGuardavidas')->dropDownList($items, ['prompt' => 'Todos'])
    ?>

    <?= $form->field($model, 'puesto') ?>
    <label class="control-label" for="dealerAvailableDate">Fecha</label>
    <?php
    echo kartik\daterange\DateRangePicker::widget([
        'model' => $model,
        //'name' => "GuardavidasPuesto[Fecha]",
        //'id'=>'guardavidaspuesto-fecha',
        'attribute' => 'dealerAvailableDate',
        'convertFormat' => true,
        'pluginOptions' => [
            'locale' => [
                'format' => 'Y-m-d'
            ],
        ],
    ])
    ?>

    <?php echo $form->field($model, 'idTipo')->dropDownList(yii\helpers\ArrayHelper::map(\app\models\TipoAsistencia::find()->all(), 'idTipoAsistencia', 'Descripcion'), ['prompt' => 'Todos']) ?>


        <?php if(Yii::$app->user->identity->idRol == Asistencia::ROL_ADMIN) {echo $form->field($model, 'idEstadoAsistencia')->dropDownList(yii\helpers\ArrayHelper::map(\app\models\EstadoAsistencia::find()->all(), 'idEstadoAsistencia', 'Descripcion'), ['prompt' => 'Todos']);}?>

<?php // echo $form->field($model, 'Observacion')  ?>

    <div class="form-group">
<?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
<?php //echo Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

<?php ActiveForm::end(); ?>

</div>
