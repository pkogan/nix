<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "TipoAsistencia".
 *
 * @property int $idTipoAsistencia
 * @property string $Descripcion
 *
 * @property Asistencia[] $asistencias
 */
class TipoAsistencia extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'TipoAsistencia';
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
            'idTipoAsistencia' => 'Id Tipo Asistencia',
            'Descripcion' => 'Descripcion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAsistencias()
    {
        return $this->hasMany(Asistencia::className(), ['idTipo' => 'idTipoAsistencia']);
    }
}
