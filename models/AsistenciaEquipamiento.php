<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "AsistenciaEquipamiento".
 *
 * @property int $idAsistencia
 * @property int $idEquipameinto
 *
 * @property Equipamiento $idEquipameinto0
 * @property Asistencia $idAsistencia0
 */
class AsistenciaEquipamiento extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'AsistenciaEquipamiento';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idAsistencia', 'idEquipameinto'], 'required'],
            [['idAsistencia', 'idEquipameinto'], 'integer'],
            [['idEquipameinto'], 'exist', 'skipOnError' => true, 'targetClass' => Equipamiento::className(), 'targetAttribute' => ['idEquipameinto' => 'idEquipamiento']],
            [['idAsistencia'], 'exist', 'skipOnError' => true, 'targetClass' => Asistencia::className(), 'targetAttribute' => ['idAsistencia' => 'idAsistencia']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idAsistencia' => 'Id Asistencia',
            'idEquipameinto' => 'Id Equipameinto',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdEquipameinto0()
    {
        return $this->hasOne(Equipamiento::className(), ['idEquipamiento' => 'idEquipameinto']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdAsistencia0()
    {
        return $this->hasOne(Asistencia::className(), ['idAsistencia' => 'idAsistencia']);
    }
}
