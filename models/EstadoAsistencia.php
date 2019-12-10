<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "EstadoAsistencia".
 *
 * @property int $idEstadoAsistencia
 * @property string $Descripcion
 *
 * @property Asistencia[] $asistencias
 */
class EstadoAsistencia extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'EstadoAsistencia';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Descripcion'], 'required'],
            [['Descripcion'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idEstadoAsistencia' => 'Id Estado Asistencia',
            'Descripcion' => 'Descripcion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAsistencias()
    {
        return $this->hasMany(Asistencia::className(), ['idEstadoAsistencia' => 'idEstadoAsistencia']);
    }
}
