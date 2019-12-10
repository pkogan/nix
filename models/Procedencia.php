<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Procedencia".
 *
 * @property int $idProcedencia
 * @property string $Descripcion
 *
 * @property Victima[] $victimas
 */
class Procedencia extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Procedencia';
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
            'idProcedencia' => 'Id Procedencia',
            'Descripcion' => 'Descripcion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVictimas()
    {
        return $this->hasMany(Victima::className(), ['idProcedencia' => 'idProcedencia']);
    }
}
