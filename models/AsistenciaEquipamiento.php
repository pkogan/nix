<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "AsistenciaEquipamiento".
 *
 * @property int $idAsistencia
 * @property int $idEquipamiento
 *
 * @property Equipamiento $idEquipamiento0
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
            [['idAsistencia', 'idEquipamiento'], 'required'],
            [['idAsistencia', 'idEquipamiento'], 'integer'],
            [['idEquipamiento'], 'exist', 'skipOnError' => true, 'targetClass' => Equipamiento::className(), 'targetAttribute' => ['idEquipamiento' => 'idEquipamiento']],
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
            'idEquipamiento' => 'Id Equipameinto',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdEquipameinto0()
    {
        return $this->hasOne(Equipamiento::className(), ['idEquipamiento' => 'idEquipamiento']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdAsistencia0()
    {
        return $this->hasOne(Asistencia::className(), ['idAsistencia' => 'idAsistencia']);
    }
}
