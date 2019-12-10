<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Archivos".
 *
 * @property int $idArchivo
 * @property int $idAsistencia
 * @property string $Path
 * @property int $idTipoArchivo
 *
 * @property Asistencia $idAsistencia0
 */
class Archivos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Archivos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idAsistencia', 'Path', 'idTipoArchivo'], 'required'],
            [['idAsistencia', 'idTipoArchivo'], 'integer'],
            [['Path'], 'string', 'max' => 200],
            [['idAsistencia'], 'exist', 'skipOnError' => true, 'targetClass' => Asistencia::className(), 'targetAttribute' => ['idAsistencia' => 'idAsistencia']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idArchivo' => 'Id Archivo',
            'idAsistencia' => 'Id Asistencia',
            'Path' => 'Path',
            'idTipoArchivo' => 'Id Tipo Archivo',
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
