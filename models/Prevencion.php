<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Prevencion".
 *
 * @property int $idPrevencion
 * @property int $idAsistencia
 * @property string|null $Peligro
 * @property string|null $Comportamiento
 *
 * @property Asistencia $idAsistencia0
 */
class Prevencion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Prevencion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idAsistencia'], 'required'],
            [['idAsistencia'], 'integer'],
            [['Peligro', 'Comportamiento'], 'string'],
            [['idAsistencia'], 'exist', 'skipOnError' => true, 'targetClass' => Asistencia::className(), 'targetAttribute' => ['idAsistencia' => 'idAsistencia']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idPrevencion' => 'Id Prevencion',
            'idAsistencia' => 'Id Asistencia',
            'Peligro' => 'Peligro',
            'Comportamiento' => 'Comportamiento',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdAsistencia0()
    {
        return $this->hasOne(Asistencia::className(), ['idAsistencia' => 'idAsistencia']);
    }
}
