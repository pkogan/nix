<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Complejidad".
 *
 * @property int $idComplejidad
 * @property string $Descripcion
 *
 * @property Incidente[] $incidentes
 */
class Complejidad extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Complejidad';
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
            'idComplejidad' => 'Id Complejidad',
            'Descripcion' => 'Descripcion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIncidentes()
    {
        return $this->hasMany(Incidente::className(), ['idComplejidad' => 'idComplejidad']);
    }
}
