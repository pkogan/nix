<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "RangoEtario".
 *
 * @property int $idRangoEtario
 * @property string $Descripcion
 *
 * @property Victima[] $victimas
 */
class RangoEtario extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'RangoEtario';
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
            'idRangoEtario' => 'Id Rango Etario',
            'Descripcion' => 'Descripcion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVictimas()
    {
        return $this->hasMany(Victima::className(), ['idRangoEtario' => 'idRangoEtario']);
    }
}
