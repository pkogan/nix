<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "GuardavidasPuesto".
 *
 * @property int $idGuardavidas
 * @property int $idPuesto
 * @property string $Fecha
 *
 * @property Guardavidas $idGuardavidas0
 * @property Puesto $idPuesto0
 */
class GuardavidasPuesto extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'GuardavidasPuesto';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idGuardavidas', 'idPuesto', 'Fecha'], 'required'],
            [['idGuardavidas', 'idPuesto'], 'integer'],
            [['Fecha'], 'safe'],
            [['idGuardavidas'], 'exist', 'skipOnError' => true, 'targetClass' => Guardavidas::className(), 'targetAttribute' => ['idGuardavidas' => 'idGuardavidas']],
            [['idPuesto'], 'exist', 'skipOnError' => true, 'targetClass' => Puesto::className(), 'targetAttribute' => ['idPuesto' => 'idPuesto']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idGuardavidas' => 'Id Guardavidas',
            'idPuesto' => 'Id Puesto',
            'Fecha' => 'Fecha',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdGuardavidas0()
    {
        return $this->hasOne(Guardavidas::className(), ['idGuardavidas' => 'idGuardavidas']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPuesto0()
    {
        return $this->hasOne(Puesto::className(), ['idPuesto' => 'idPuesto']);
    }
}
