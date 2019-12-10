<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Genero".
 *
 * @property int $idGenero
 * @property string $Descripcion
 *
 * @property Victima[] $victimas
 */
class Genero extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Genero';
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
            'idGenero' => 'Id Genero',
            'Descripcion' => 'Descripcion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVictimas()
    {
        return $this->hasMany(Victima::className(), ['idGenero' => 'idGenero']);
    }
}
