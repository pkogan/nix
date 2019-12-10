<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Puesto".
 *
 * @property int $idPuesto
 * @property int $idBalneario
 * @property string $Lugar
 *
 * @property GuardavidasPuesto[] $guardavidasPuestos
 * @property Balneario $idBalneario0
 */
class Puesto extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Puesto';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idBalneario', 'Lugar'], 'required'],
            [['idBalneario'], 'integer'],
            [['Lugar'], 'string'],
            [['idBalneario'], 'exist', 'skipOnError' => true, 'targetClass' => Balneario::className(), 'targetAttribute' => ['idBalneario' => 'idBalneario']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idPuesto' => 'Id Puesto',
            'idBalneario' => 'Id Balneario',
            'Lugar' => 'Lugar',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGuardavidasPuestos()
    {
        return $this->hasMany(GuardavidasPuesto::className(), ['idPuesto' => 'idPuesto']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdBalneario0()
    {
        return $this->hasOne(Balneario::className(), ['idBalneario' => 'idBalneario']);
    }
}
