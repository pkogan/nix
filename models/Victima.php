<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Victima".
 *
 * @property int $idVictima
 * @property int $idGenero
 * @property int $idRangoEtario
 * @property int $Cantidad
 * @property int $idProcedencia
 * @property int $idAsistencia
 *
 * @property Asistencia $idAsistencia0
 * @property RangoEtario $idRangoEtario0
 * @property Genero $idGenero0
 * @property Procedencia $idProcedencia0
 */
class Victima extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Victima';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idGenero', 'idRangoEtario', 'Cantidad', 'idProcedencia', 'idAsistencia'], 'required'],
            [['idGenero', 'idRangoEtario', 'Cantidad', 'idProcedencia', 'idAsistencia'], 'integer'],
            [['idAsistencia'], 'exist', 'skipOnError' => true, 'targetClass' => Asistencia::className(), 'targetAttribute' => ['idAsistencia' => 'idAsistencia']],
            [['idRangoEtario'], 'exist', 'skipOnError' => true, 'targetClass' => RangoEtario::className(), 'targetAttribute' => ['idRangoEtario' => 'idRangoEtario']],
            [['idGenero'], 'exist', 'skipOnError' => true, 'targetClass' => Genero::className(), 'targetAttribute' => ['idGenero' => 'idGenero']],
            [['idProcedencia'], 'exist', 'skipOnError' => true, 'targetClass' => Procedencia::className(), 'targetAttribute' => ['idProcedencia' => 'idProcedencia']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idVictima' => 'Id Victima',
            'idGenero' => 'Id Genero',
            'idRangoEtario' => 'Id Rango Etario',
            'Cantidad' => 'Cantidad',
            'idProcedencia' => 'Id Procedencia',
            'idAsistencia' => 'Id Asistencia',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdAsistencia0()
    {
        return $this->hasOne(Asistencia::className(), ['idAsistencia' => 'idAsistencia']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdRangoEtario0()
    {
        return $this->hasOne(RangoEtario::className(), ['idRangoEtario' => 'idRangoEtario']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdGenero0()
    {
        return $this->hasOne(Genero::className(), ['idGenero' => 'idGenero']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProcedencia0()
    {
        return $this->hasOne(Procedencia::className(), ['idProcedencia' => 'idProcedencia']);
    }
}
