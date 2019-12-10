<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Incidente".
 *
 * @property int $idIncidente
 * @property int $idAsistencia
 * @property int|null $idComplejidad
 *
 * @property Asistencia $idAsistencia0
 * @property Complejidad $idComplejidad0
 * @property PrimerosAuxiliosIncidente[] $primerosAuxiliosIncidentes
 */
class Incidente extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Incidente';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idAsistencia'], 'required'],
            [['idAsistencia', 'idComplejidad'], 'integer'],
            [['idAsistencia'], 'exist', 'skipOnError' => true, 'targetClass' => Asistencia::className(), 'targetAttribute' => ['idAsistencia' => 'idAsistencia']],
            [['idComplejidad'], 'exist', 'skipOnError' => true, 'targetClass' => Complejidad::className(), 'targetAttribute' => ['idComplejidad' => 'idComplejidad']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idIncidente' => 'Id Incidente',
            'idAsistencia' => 'Id Asistencia',
            'idComplejidad' => 'Id Complejidad',
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
    public function getIdComplejidad0()
    {
        return $this->hasOne(Complejidad::className(), ['idComplejidad' => 'idComplejidad']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrimerosAuxiliosIncidentes()
    {
        return $this->hasMany(PrimerosAuxiliosIncidente::className(), ['idIncidente' => 'idIncidente']);
    }
}
