<?php

namespace app\models;
use DateTime;
use \yii\db\Expression;
use Yii;

/**
 * This is the model class for table "Asistencia".
 *
 * @property int $idAsistencia
 * @property int $idGuardavidas
 * @property DateTime $Fecha
 * @property int $idTipo
 * @property int $idEstadoAsistencia
 * @property string|null $Lugar
 * @property int|null $latitude
 * @property int|null $longitude
 * @property string|null $Observacion
 * @property int|null $idPuesto
 * 
 *
 * @property Archivos[] $archivos
 * @property Guardavidas $idGuardavidas0
 * @property TipoAsistencia $idTipo0
 * @property EstadoAsistencia $idEstadoAsistencia0
 * @property Puesto $idPuesto0
 * @property AsistenciaEquipamiento[] $asistenciaEquipamientos
 * @property Incidente[] $incidentes
 * @property Prevencion[] $prevencions
 * @property Victima[] $victimas
 */
class Asistencia extends \yii\db\ActiveRecord {

    const TIPO_RESCATE = 1;
    const TIPO_PRIMEROSAUXILIOS = 2;
    const TIPO_PREVENCION = 3;
    const TIPO_NOVEDAD = 4;
    const ESTADO_ABIERTA = 1;
    const ESTADO_CERRADA = 2;
    const ESTADO_BAJA = 3;
    const ROL_GUARDAVIDAS = 1;
    const ROL_JEFE = 2;
    const ROL_INGRESANTE = 3;
    const ROL_ADMIN = 4;
    const COMPLEJIDAD_MEDIA = 2;

    public $latitude;
    public $longitude;

    static function find() {
        $fieldName = 'Asistencia.Lugar';
        $query = parent::find()->addSelect('*')->addSelect(new Expression("Y([[{$fieldName}]]) as latitude"))
                        ->addSelect(new Expression("X([[{$fieldName}]]) as longitude"))->joinWith('idGuardavidas0');
        //TODO cambiar a roles BBDD si el usr es admin muestra todos
        //si es guardavidas o ingresante debe ver solo sus rescates
        //si es jefe debe ver solo Guardavidas
        //si es admin ve todo
        if (Yii::$app->user->identity->idRol != Asistencia::ROL_ADMIN) {
            $query->andWhere('idEstadoAsistencia=' . Asistencia::ESTADO_CERRADA);
        }
        $in=[];
        if (count(Yii::$app->user->identity->guardavidasPuestos) > 0) {
            /* @var $guardavidasPuesto GuardavidasPuesto    */
            $guardavidasPuesto = Yii::$app->user->identity->guardavidasPuestos[0];
            //print_r($guardavidasPuesto->idPuesto0);exit;
            $puestos= GuardavidasPuesto::find()->joinWith('idPuesto0')->where('idBalneario='.$guardavidasPuesto->idPuesto0->idBalneario)->all();
            //print_r($puestos);exit;
            foreach($puestos as $guardavidasPuestos){
                /* @var $guardavidasPuestos GuardavidasPuesto    */
                $in[]=$guardavidasPuestos->idGuardavidas;
            }
            $in=array_unique($in);
            $in= '('.implode(',', $in).')';
        }else{
            $in='('.Yii::$app->user->identity->id.')';
        }

        if (Yii::$app->user->identity->idRol == Asistencia::ROL_GUARDAVIDAS || Yii::$app->user->identity->idRol == Asistencia::ROL_INGRESANTE) {
            $query->andWhere('Guardavidas.idGuardavidas in ' . $in);
        } elseif (Yii::$app->user->identity->idRol == Asistencia::ROL_JEFE) {
            $query->andWhere('Guardavidas.idRol in (' . Asistencia::ROL_GUARDAVIDAS . ',' . Asistencia::ROL_JEFE . ')');
        }
        return $query;
    }

    public function latlong($fieldName) {
        $this->addSelect(new Expression("ST_X([[{$fieldName}]]) as latitude"));
        $this->addSelect(new Expression("ST_Y([[{$fieldName}]]) as longitude"));
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'Asistencia';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
                [['idGuardavidas', 'Fecha', 'idTipo', 'idEstadoAsistencia'], 'required'],
                [['latitude', 'longitude', 'idGuardavidas', 'idTipo', 'idEstadoAsistencia', 'idPuesto'], 'integer'],
                [['Fecha'], 'safe'],
                [['Lugar'], 'position'],
                [['Observacion'], 'string'],
                [['idGuardavidas'], 'exist', 'skipOnError' => true, 'targetClass' => Guardavidas::className(), 'targetAttribute' => ['idGuardavidas' => 'idGuardavidas']],
                [['idTipo'], 'exist', 'skipOnError' => true, 'targetClass' => TipoAsistencia::className(), 'targetAttribute' => ['idTipo' => 'idTipoAsistencia']],
                [['idTipo'], 'targetClass' => Puesto::className(), 'targetAttribute' => ['idPuesto' => 'idPuesto']],
                [['idEstadoAsistencia'], 'exist', 'skipOnError' => true, 'targetClass' => EstadoAsistencia::className(), 'targetAttribute' => ['idEstadoAsistencia' => 'idEstadoAsistencia']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'idAsistencia' => 'Id Asistencia',
            'idGuardavidas' => 'Guardavidas',
            'Fecha' => 'Fecha',
            'idTipo' => 'Tipo',
            'idPuesto' => 'Puesto',
            'idEstadoAsistencia' => 'Id Estado Asistencia',
            'Lugar' => 'Lugar',
            'Observacion' => 'Observacion',
        ];
    }

    public function getVictimasStr() {
        if (count($this->victimas) > 0) {
            $victima = [];
            foreach ($this->victimas as $key => $value) {
                /* @var $value app\models\Victima */
                $victima[] = $value->Cantidad . ' ' . $value->idRangoEtario0->Descripcion;
            }
            return implode(', ', $victima);
        } else {
            return '';
        }
    }
    public function getVictimasCount() {
        $victima = 0;
        if (count($this->victimas) > 0) {
            
            foreach ($this->victimas as $key => $value) {
                /* @var $value app\models\Victima */
                $victima+= $value->Cantidad ;
            }
            
        } 
        return $victima;
    }
    public function getFechaStr(){
        $date = new DateTime($this->Fecha);
        return $date->format('m-d');
        //return $this->Fecha->format('Y-m-d H:i:s');
        
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArchivos() {
        return $this->hasMany(Archivos::className(), ['idAsistencia' => 'idAsistencia']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdGuardavidas0() {
        return $this->hasOne(Guardavidas::className(), ['idGuardavidas' => 'idGuardavidas']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPuesto0() {
        return $this->hasOne(Puesto::className(), ['idPuesto' => 'idPuesto']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdTipo0() {
        return $this->hasOne(TipoAsistencia::className(), ['idTipoAsistencia' => 'idTipo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdEstadoAsistencia0() {
        return $this->hasOne(EstadoAsistencia::className(), ['idEstadoAsistencia' => 'idEstadoAsistencia']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAsistenciaEquipamientos() {
        return $this->hasMany(AsistenciaEquipamiento::className(), ['idAsistencia' => 'idAsistencia']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIncidentes() {
        return $this->hasMany(Incidente::className(), ['idAsistencia' => 'idAsistencia']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrevencions() {
        return $this->hasMany(Prevencion::className(), ['idAsistencia' => 'idAsistencia']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVictimas() {
        return $this->hasMany(Victima::className(), ['idAsistencia' => 'idAsistencia']);
    }

}
