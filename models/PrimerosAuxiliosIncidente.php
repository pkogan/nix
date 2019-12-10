<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "PrimerosAuxiliosIncidente".
 *
 * @property int $idPrimerosAuxilios
 * @property int $idIncidente
 *
 * @property PrimerosAuxilios $idPrimerosAuxilios0
 * @property Incidente $idIncidente0
 */
class PrimerosAuxiliosIncidente extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'PrimerosAuxiliosIncidente';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idPrimerosAuxilios', 'idIncidente'], 'required'],
            [['idPrimerosAuxilios', 'idIncidente'], 'integer'],
            [['idPrimerosAuxilios'], 'exist', 'skipOnError' => true, 'targetClass' => PrimerosAuxilios::className(), 'targetAttribute' => ['idPrimerosAuxilios' => 'idPrimerosAuxilios']],
            [['idIncidente'], 'exist', 'skipOnError' => true, 'targetClass' => Incidente::className(), 'targetAttribute' => ['idIncidente' => 'idIncidente']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idPrimerosAuxilios' => 'Id Primeros Auxilios',
            'idIncidente' => 'Id Incidente',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPrimerosAuxilios0()
    {
        return $this->hasOne(PrimerosAuxilios::className(), ['idPrimerosAuxilios' => 'idPrimerosAuxilios']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdIncidente0()
    {
        return $this->hasOne(Incidente::className(), ['idIncidente' => 'idIncidente']);
    }
}
