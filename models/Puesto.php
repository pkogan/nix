<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Puesto".
 *
 * @property int $idPuesto
 * @property string $Nombre
 * @property int $idBalneario
 * @property string $Lugar

 *
 * @property GuardavidasPuesto[] $guardavidasPuestos
 * @property Balneario $idBalneario0
 */
class Puesto extends \yii\db\ActiveRecord {

    public $latitude;
    public $longitude;

    
    static function find() {
        $fieldName = 'Lugar';
        $query = parent::find()->addSelect('Puesto.*')->addSelect(new \yii\db\Expression("Y([[{$fieldName}]]) as latitude"))
                        ->addSelect(new \yii\db\Expression("X([[{$fieldName}]]) as longitude"));
        return $query;
    }
    public function load($data, $formName = null) {
        //print_r($data);exit;
        if(isset($data['Puesto']['latitude'])){
        $this->latitude=$data['Puesto']['latitude'];
        $this->longitude=$data['Puesto']['longitude'];
        }
        return parent::load($data, $formName);
    }

    public function beforeSave($insert) {
        
    // WORKS: using the following line works to insert POINT(0 0)
    //$this->coordinates = new CDbExpression("GeomFromText('POINT(0 0)')");

    // DOESN'T WORK: using the following line gives an error
        //$this->Lugar= new \yii\db\Expression("GeomFromText('POINT(".$this->latitude." ".$this->longitude.")')");
        //list($latitude , $longitude) = explode(',' , $this->Lugar);
        //print_r($insert);
        $this->Lugar = new \yii\db\Expression("point({$this->longitude},{$this->latitude})");
        //echo $this->Lugar;//exit;
        return parent::beforeSave($insert);
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'Puesto';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
                [['Nombre', 'idBalneario'], 'required'],
                [['idBalneario'], 'integer'],
                [['Lugar'], 'string'],
                [['Nombre'], 'string', 'max' => 10],
                [['idBalneario'], 'exist', 'skipOnError' => true, 'targetClass' => Balneario::className(), 'targetAttribute' => ['idBalneario' => 'idBalneario']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'idPuesto' => 'Id Puesto',
            'Nombre' => 'Nombre',
            'idBalneario' => 'Id Balneario',
            'Lugar' => 'Lugar',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGuardavidasPuestos() {
        return $this->hasMany(GuardavidasPuesto::className(), ['idPuesto' => 'idPuesto']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdBalneario0() {
        return $this->hasOne(Balneario::className(), ['idBalneario' => 'idBalneario']);
    }

}
