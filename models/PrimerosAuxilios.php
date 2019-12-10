<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "PrimerosAuxilios".
 *
 * @property int $idPrimerosAuxilios
 * @property string $Descripcion
 *
 * @property PrimerosAuxiliosIncidente[] $primerosAuxiliosIncidentes
 */
class PrimerosAuxilios extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'PrimerosAuxilios';
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
            'idPrimerosAuxilios' => 'Id Primeros Auxilios',
            'Descripcion' => 'Descripcion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrimerosAuxiliosIncidentes()
    {
        return $this->hasMany(PrimerosAuxiliosIncidente::className(), ['idPrimerosAuxilios' => 'idPrimerosAuxilios']);
    }
}
