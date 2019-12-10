<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Equipamiento".
 *
 * @property int $idEquipamiento
 * @property int $idTipoAsistencia
 * @property string $Descripcion
 *
 * @property AsistenciaEquipamiento[] $asistenciaEquipamientos
 */
class Equipamiento extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Equipamiento';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idTipoAsistencia', 'Descripcion'], 'required'],
            [['idTipoAsistencia'], 'integer'],
            [['Descripcion'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idEquipamiento' => 'Id Equipamiento',
            'idTipoAsistencia' => 'Id Tipo Asistencia',
            'Descripcion' => 'Descripcion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAsistenciaEquipamientos()
    {
        return $this->hasMany(AsistenciaEquipamiento::className(), ['idEquipameinto' => 'idEquipamiento']);
    }
}
