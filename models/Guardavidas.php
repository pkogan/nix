<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Guardavidas".
 *
 * @property int $idGuardavidas
 * @property string $Nombre
 * @property int $idRol
 * @property string $idTelegram
 * @property string $Mail
 *
 * @property Asistencia[] $asistencias
 * @property Rol $idRol0
 * @property GuardavidasPuesto[] $guardavidasPuestos
 */
class Guardavidas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Guardavidas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Nombre', 'idRol', 'idTelegram', 'Mail'], 'required'],
            [['idRol'], 'integer'],
            [['Nombre', 'idTelegram', 'Mail'], 'string', 'max' => 100],
            [['idRol'], 'exist', 'skipOnError' => true, 'targetClass' => Rol::className(), 'targetAttribute' => ['idRol' => 'idRol']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idGuardavidas' => 'Id Guardavidas',
            'Nombre' => 'Nombre',
            'idRol' => 'Id Rol',
            'idTelegram' => 'Id Telegram',
            'Mail' => 'Mail',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAsistencias()
    {
        return $this->hasMany(Asistencia::className(), ['idGuardavidas' => 'idGuardavidas']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdRol0()
    {
        return $this->hasOne(Rol::className(), ['idRol' => 'idRol']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGuardavidasPuestos()
    {
        return $this->hasMany(GuardavidasPuesto::className(), ['idGuardavidas' => 'idGuardavidas']);
    }
}
