<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\GuardavidasPuesto */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="guardavidas-puesto-form">

    <?php $form = ActiveForm::begin(); ?>

    <?=  $form->field($model,'idGuardavidas')->dropDownList(yii\helpers\ArrayHelper::map(\app\models\Guardavidas::find()->where('idRol='.\app\models\Asistencia::ROL_GUARDAVIDAS)->all(),'idGuardavidas','Nombre')) ?> 

    <?= $form->field($model,'idPuesto')->dropDownList(yii\helpers\ArrayHelper::map(\app\models\Puesto::find()->all(),'idPuesto','Nombre')) ?>
    <label class="control-label" for="guardavidaspuesto-fecha">Fecha</label>
    <?= DatePicker::widget([
    'name' => "GuardavidasPuesto[Fecha]",
    'id'=>'guardavidaspuesto-fecha',
    'type' => DatePicker::TYPE_INPUT,
    'value' => $model->Fecha,
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd'
    ]
]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
