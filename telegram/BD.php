<?php

namespace telegram;

use \PDO;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BD
 *
 * @author pablo
 */
class BD extends PDO {

    private $tipo_de_base = 'mysql';

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
    const COMPLEJIDAD_MEDIA = 2;

    public function __construct() {
        include 'config.php';
        $this->host = $config['host'];
        $this->nombre_de_base = $config['nombre_de_base'];
        $this->usuario = $config['usuario'];
        $this->contrasena = $config['contrasena'];

        //Sobreescribo el método constructor de la clase PDO.
        try {
            parent::__construct("{$this->tipo_de_base}:dbname={$this->nombre_de_base};host={$this->host};charset=utf8", $this->usuario, $this->contrasena);
        } catch (PDOException $e) {
            echo 'Ha surgido un error y no se puede conectar a la base de datos. Detalle: ' . $e->getMessage();
            exit;
        }
    }

    public function buscarUsuario($request) {
        $idGuardavidas = $this->buscarGuardavidas($request);
        $sql = "select * from Guardavidas where idGuardavidas=\"$idGuardavidas\"";
        $guardavidas = $this->consulta($sql);
        if (count($guardavidas) != 1) {
            return null;
        } else {
            return $guardavidas[0];
        }
    }

    /* Busca Guardavidas y si no lo encuentra lo agrega. retorna idGuardavidas */

    public function buscarGuardavidas($request) {
        //print_r($request);
        $idTelegram = $request->id;
        $sql = "select * from Guardavidas where idTelegram=\"$idTelegram\"";
        $guardavidas = $this->consulta($sql);
        if (count($guardavidas) != 1) {
            //insertar guardavidas
            //INSERT INTO `Guardavidas`(`idGuardavidas`, `Nombre`, `idRol`, `idTelegram`, `Mail`) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5])
            $Nombre = $request->last_name . ' ' . $request->first_name;
            $idRol = BD::ROL_INGRESANTE;
            $Mail = "";
            $sql = "INSERT INTO `Guardavidas`( `Nombre`, `idRol`, `idTelegram`, `Mail`) VALUES (\"$Nombre\",$idRol,\"$idTelegram\",\"$Mail\")";
            try {
                $this->prepare($sql)->execute();
            } catch (PDOException $e) {
                return $e->getMessage();
            }
            return $this->buscarGuardavidas($request);
        } else {
            //print_r($guardavidas);
            return $guardavidas[0]['idGuardavidas'];
        }
    }

    public function insertRescate($request) {
        return $this->insertAsistencia($request, BD::TIPO_RESCATE);
    }

    public function insertAsistencia($request, $idTipo = BD::TIPO_RESCATE) {
        /* INSERT INTO `Asistencia`(`idAsistencia`, `idGuardavidas`, `Fecha`, `idTipo`, `Lugar`, `Observación`) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6]) */
        /* hay que buscar si existe el guardavidas y obtener el id */
        $idGuardavidas = $this->buscarGuardavidas($request);
        //$idGuardavidas=1;
        $Lugar = 'null';
        $idEstado = BD::ESTADO_ABIERTA;
        $Observacion = 'null';
        $Fecha = date('Y-m-d H:i:s');

        // si es novedad solo guarda Asistencia
        $sql = "INSERT INTO `Asistencia`( `idGuardavidas`, `Fecha`, `idTipo`, `idEstadoAsistencia`, `Lugar`, `Observacion`) VALUES ($idGuardavidas, \"$Fecha\", $idTipo, $idEstado, $Lugar, $Observacion);";
        echo $sql;
        try {
            $this->prepare($sql)->execute();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
        if (in_array($idTipo, [BD::TIPO_RESCATE, BD::TIPO_PRIMEROSAUXILIOS])) {
            $idAsistencia = $this->buscarAsistenciaAbierta($request);
            $idComplejidad = BD::COMPLEJIDAD_MEDIA;
            $sql = "INSERT INTO `Incidente`( `idAsistencia`, `idComplejidad`) VALUES ($idAsistencia,$idComplejidad);";
            echo $sql;
            try {
                $this->prepare($sql)->execute();
            } catch (PDOException $e) {
                return $e->getMessage();
            }
            return $sql;
        } elseif ($idTipo == BD::TIPO_PREVENCION) {
            $sql = "INSERT INTO `Prevencion`( `idAsistencia`) VALUES ($idAsistencia);";
            echo $sql;
            try {
                $this->prepare($sql)->execute();
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }
    }

    public function buscarAsistenciaAbierta($request) {
        $idGuardavidas = $this->buscarGuardavidas($request);
        $estadoAbierta = BD::ESTADO_ABIERTA;
        $sql = "select * from Asistencia where idGuardavidas=$idGuardavidas and idEstadoAsistencia=$estadoAbierta";
        $asistencia = $this->consulta($sql);
        if (count($asistencia) == 0) {
            //$this->insertRescate($request);
            return 0; //$this->buscarAsistenciaAbierta($request);
        } else {
            return $asistencia[0]['idAsistencia'];
        }
    }

    public function buscarIncidente($idAsistencia) {
        $sql = "select * from Incidente where idAsistencia=$idAsistencia";
        $asistencia = $this->consulta($sql);
        if (count($asistencia) == 0) {
            //$this->insertRescate($request);
            return 0; //$this->buscarAsistenciaAbierta($request);
        } else {
            return $asistencia[0]['idIncidente'];
        }
    }

    public function updateLugar($idAsistencia, $request) {

        $lat = $request->latitude;
        $long = $request->longitude;
        $sql = "update Asistencia set Lugar=POINT($long,$lat) where idAsistencia=$idAsistencia";
        try {
            $this->prepare($sql)->execute();
        } catch (PDOException $e) {
            return $e->getMessage();
        }

        return $sql;
    }

    public function updateFecha($idAsistencia, $Fecha) {

        $sql = "update Asistencia set Fecha=\"$Fecha\" where idAsistencia=$idAsistencia";
        echo $sql;
        try {
            $this->prepare($sql)->execute();
        } catch (PDOException $e) {
            return $e->getMessage();
        }

        return $sql;
    }

    public function updateObservacion($idAsistencia, $Obs) {

        $sql = "update Asistencia set Observacion=\"$Obs\" where idAsistencia=$idAsistencia";
        try {
            $this->prepare($sql)->execute();
        } catch (PDOException $e) {
            return $e->getMessage();
        }

        return $sql;
    }

    public function obtenerCaracteristica($idAsistencia, $tabla) {

        return $this->consulta($sql);
    }

    public function mostrarAsistencia($idAsistencia) {
        $sql = "SELECT a.idAsistencia,a.Fecha, t.Descripcion as Tipo,Observacion,Lugar, sum(v.Cantidad) Victimas, count(ar.idArchivo) Archivos FROM Asistencia a 
inner join TipoAsistencia t on a.idTipo=t.idTipoAsistencia
left outer join Victima v on a.idAsistencia=v.idAsistencia
left outer join Archivos ar on a.idAsistencia=ar.idAsistencia
        where a.idAsistencia=$idAsistencia
group by a.idAsistencia";
        $asistencia = $this->consulta($sql);
        $rangoEtario = $this->consulta("Select * from Victima v inner join RangoEtario r on v.idRangoEtario=r.idRangoEtario where idAsistencia=$idAsistencia");
        if (!is_null($asistencia[0]['Victimas'])) {
            $strRango = [];

            foreach ($rangoEtario as $key => $value) {
                $strRango[] = $value['Cantidad'] . ' ' . $value['Descripcion'];
            }
            $strRango = '(' . implode(', ', $strRango) . ') ';
        }
        $mensaje = 'Alta Registro. ' . $asistencia[0]['Tipo'] . ' #' . $idAsistencia . ' ' . $asistencia[0]['Fecha'] . ' ' . $strRango . $asistencia[0]['Observacion'];
        return $mensaje;
    }

    public function cerrarAsistencia($request) {
        $idAsistencia = $this->buscarAsistenciaAbierta($request);
        if ($idAsistencia != 0) {
            $estadoCerrada = BD::ESTADO_CERRADA;
            $sql = "update Asistencia set idEstadoAsistencia=$estadoCerrada where idAsistencia=$idAsistencia";
            try {
                $this->prepare($sql)->execute();
            } catch (PDOException $e) {
                return $e->getMessage();
            }
            return $this->mostrarAsistencia($idAsistencia);
        } else {
            return $idAsistencia;
        }
    }

    public function updateEstadoAsistencia($idAsistencia, $idEstadoAsistencia) {

        if ($idAsistencia != 0) {
            $sql = "update Asistencia set idEstadoAsistencia=$idEstadoAsistencia where idAsistencia=$idAsistencia";
            try {
                $this->prepare($sql)->execute();
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }
        return $idAsistencia;
    }

    public function insertArchivo($idAsistencia, $path) {

        $idTipoArchivo = 1;
        //INSERT INTO `Archivos`(`idArchivo`, `idAsistencia`, `Path`, `idTipoArchivo`) VALUES ([value-1],[value-2],[value-3],[value-4])
        $sql = "INSERT INTO `Archivos`(`idAsistencia`, `Path`, `idTipoArchivo`) VALUES ($idAsistencia,\"$path\",$idTipoArchivo)";
        try {
            $this->prepare($sql)->execute();
        } catch (PDOException $e) {
            return $e->getMessage();
        }

        return $sql;
    }

    // si no existe se crea y si existe se actuliza
    public function updateVictima($idAsistencia, $datos) {

        if ($datos[0] == 'RangoEtario') {
            $idRangoEtario = $datos[1];

            $sql = "select * from Victima	where idAsistencia=$idAsistencia and idRangoEtario=$idRangoEtario";
            echo $sql;
            $victima = $this->consulta($sql);
            //print_r($victima);
            if (count($victima) == 0) {
                //INSERT INTO `Victima`(`idVictima`, `idGenero`, `idRangoEtario`, `Cantidad`, `idProcedencia`, `idAsistencia`) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6])
                //para prototipo genero Otres y Procedencia Locales
                $sql = "INSERT INTO `Victima`( `idGenero`, `idRangoEtario`, `Cantidad`, `idProcedencia`, `idAsistencia`) VALUES (3,$idRangoEtario,1,1,$idAsistencia)";
            } else {
                //UPDATE `Victima` SET `idVictima`=[value-1],`idGenero`=[value-2],`idRangoEtario`=[value-3],`Cantidad`=[value-4],`idProcedencia`=[value-5],`idAsistencia`=[value-6] WHERE 1
                $sql = "UPDATE `Victima` SET `Cantidad`=`Cantidad`+1 WHERE idVictima=" . $victima[0]['idVictima'];
            }
            try {
                $this->prepare($sql)->execute();
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }
    }

    public function updatePrimerosAuxilios($idAsistencia, $datos) {


        $idPrimerosAuxilios = $datos[1];
        $idIncidente = $this->buscarIncidente($idAsistencia);

        $sql = "select * from PrimerosAuxiliosIncidente where idIncidente=$idIncidente and idPrimerosAuxilios=$idPrimerosAuxilios";
        echo $sql;
        $primerosAuxilios = $this->consulta($sql);
        //print_r($primerosAuxilios);
        if (count($primerosAuxilios) == 0) {
            //INSERT INTO `Victima`(`idVictima`, `idGenero`, `idRangoEtario`, `Cantidad`, `idProcedencia`, `idAsistencia`) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6])
            //para prototipo genero Otres y Procedencia Locales
            $sql = "INSERT INTO `PrimerosAuxiliosIncidente`( `idPrimerosAuxilios`, `idIncidente`) VALUES ($idPrimerosAuxilios,$idIncidente)";
            echo $sql;
            try {
                $this->prepare($sql)->execute();
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }
    }

    public function updateComplejidad($idAsistencia, $datos) {

        $idComplejidad = $datos[1];



        $sql = "UPDATE `Incidente` SET `idComplejidad`=$idComplejidad WHERE idAsistencia=" . $idAsistencia;

        try {
            $this->prepare($sql)->execute();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function getDescripciones($tabla, $where = null) {
        $sql = "select * from $tabla";
        if (!is_null($where)) {
            $sql .= " where $where";
        }
        $registros = $this->consulta($sql);
        $descripciones = [];
        //print_r($registros);
        foreach ($registros as $registro) {
            $descripciones[] = ['text' => $registro['Descripcion'], 'callback_data' => $tabla . '-' . $registro["id$tabla"]];
        }
        return $descripciones;
    }

    public
            function consulta($sql) {
        try {
            $consulta = $this->prepare($sql);
            $consulta->execute();
            return $consulta->fetchAll();
        } catch (Exception $ex) {
            echo 'Ha surgido un error. Detalle: ' . $e->getMessage();
            exit;
        }
    }

}
