<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Rol".
 *
 * @property int $idRol
 * @property string $Descripcion
 *
 * @property Guardavidas[] $guardavidas
 */
class Rol extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Rol';
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
            'idRol' => 'Id Rol',
            'Descripcion' => 'Descripcion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGuardavidas()
    {
        return $this->hasMany(Guardavidas::className(), ['idRol' => 'idRol']);
    }
}
