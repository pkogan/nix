<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Balneario".
 *
 * @property int $idBalneario
 * @property string $Nombre
 * @property string $Dirección
 *
 * @property Puesto[] $puestos
 */
class Balneario extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Balneario';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Nombre', 'Dirección'], 'required'],
            [['Nombre'], 'string', 'max' => 100],
            [['Dirección'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idBalneario' => 'Id Balneario',
            'Nombre' => 'Nombre',
            'Dirección' => 'Dirección',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPuestos()
    {
        return $this->hasMany(Puesto::className(), ['idBalneario' => 'idBalneario']);
    }
}
