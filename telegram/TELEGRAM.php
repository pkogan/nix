<?php

namespace telegram;

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
class TELEGRAM {

    private $TOKEN;
    private $file_log = 'registro_de_nix.log';

    /**
     *
     * @var \telegram\BD
     */
    private $bd;

    public function __construct() {
        include 'config.php';
        $this->TOKEN = $config['TOKEN'];
        $this->file_log = $config['file_log'];
    }

    public function setBD($bd) {
        $this->bd = $bd;
    }

    public function getFile($file_id, $tipo = 'photos') {

        $url = "https://api.telegram.org:443/bot{$this->TOKEN}/getFile?file_id=$file_id";
        $response = file_get_contents($url);
        $request = json_decode($response);
        file_put_contents($this->file_log, 'photo - ' . $url . ' - ' . $response, FILE_APPEND);
        $url = "https://api.telegram.org:443/file/bot{$this->TOKEN}/" . $request->result->file_path;
        $path = 'archivos/' . $request->result->file_id . str_replace($tipo . "/", "", $request->result->file_path);
        ;
        file_put_contents($this->file_log, 'archivo - ' . $url . ' - ' . $path, FILE_APPEND);
        $data = file_get_contents($url);
        file_put_contents($path, $data, FILE_APPEND);
        return $path;
    }

    /**
      answerCallbackQuery
      Use this method to send answers to callback queries sent from inline keyboards. The answer will be displayed to the user as a notification at the top of the chat screen or as an alert. On success, True is returned.

      Alternatively, the user can be redirected to the specified Game URL. For this option to work, you must first create a game for your bot via @Botfather and accept the terms. Otherwise, you may use links like t.me/your_bot?start=XXXX that open your bot with a parameter.

      Parameter	Type	Required	Description
      callback_query_id	String	Yes	Unique identifier for the query to be answered
      text	String	Optional	Text of the notification. If not specified, nothing will be shown to the user, 0-200 characters
     */
    public function sendAswerCallback($callback_query_id, $text, $show_alert = FALSE) {
        $url = "https://api.telegram.org:443/bot{$this->TOKEN}/answerCallbackQuery";
        $data = array(
            'callback_query_id' => $callback_query_id,
            'text' => $text,
            'show_alert' => $show_alert
                //'parse_mode'=> "Markdown", // Optional: Markdown | HTML
        );

        /*         * ** envio por post curl */
        if (!$curld = curl_init()) {
            exit;
        }
        curl_setopt($curld, CURLOPT_POST, true);
        curl_setopt($curld, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curld, CURLOPT_URL, $url);
        curl_setopt($curld, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($curld);
        curl_close($curld);
        return $output;


        /*         * *************** */
    }

    public function procesarBotones($buttons) {
        //se divide en lineas de a 4 botones
        
        $botones4 = [];
        $row = [];
        $texto='';
        foreach ($buttons as $rowActual) {
            foreach ($rowActual as $key => $value) {
                if ($key >= 4 && strlen($texto)>5) {
                    $botones4[] = $row;
                    $row = [];
                    $texto='';
                }
                //print_r($value);exit();
                $texto.=$value['text'];
                $row[] = $value;
            }
            if (count($row) > 0) {
                $botones4[] = $row;
                $row = [];
            }
        }
        return $botones4;
    }

    public function sendMessage($chatId, $text, $buttons = null) {
        /**
          Para setear en webhook hay que:
          https://api.telegram.org/bot707416034:AAF5msJweymVO3FUKvs41g8w2pgvy4YIlpo/setWebHook?url=https://nix.fi.uncoma.edu.ar/web/webhook.php
         */
        $url = "https://api.telegram.org:443/bot{$this->TOKEN}/sendMessage";
        $data = array(
            'chat_id' => $chatId,
            'text' => $text,
            'disable_notification' => TRUE,
                //'parse_mode'=> "Markdown", // Optional: Markdown | HTML
        );


        if ($buttons != null) {
            $keyboard = ['inline_keyboard' => $this->procesarBotones($buttons)];

            $markup = json_encode($keyboard);
            $data['reply_markup'] = $markup;

//[		'keyboard' => $buttons,		'resize_keyboard' => true,		'one_time_keyboard' => false,		'parse_mode' => 'HTML',		'selective' => true		];
        }

        /*         * ***** envio por get	
          $query = http_build_query($data);
          $response = file_get_contents("$url?$query");
          return $response;
          /********** */
        /*         * ** envio por post curl */
        if (!$curld = curl_init()) {
            exit;
        }
        curl_setopt($curld, CURLOPT_POST, true);
        curl_setopt($curld, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curld, CURLOPT_URL, $url);
        curl_setopt($curld, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($curld);
        curl_close($curld);
        return $output;


        /*         * *************** */
    }

    function procesar($request) {

        $fecha = date('Y-m-d H:i:s');
//echo noticias();

        file_put_contents($this->file_log, $fecha . ' - ' . $request, FILE_APPEND);
        $request = json_decode($request);
        $date = date_create();
        date_timestamp_set($date, $request->message->date);
        //echo $request->message->date; 
        
        $fecha= date_format($date, 'Y-m-d H:i:s');
        //exit();
        if (isset($request->message->text)) {
            echo('-----------Mensaje: ' . $request->message->text);
        }
        /*         * callback */
        if (isset($request->callback_query->data)) {
            file_put_contents($this->file_log, $fecha . ' callback- ' . $request->callback_query->data, FILE_APPEND);
            $callback = explode('-', $request->callback_query->data);

            $idAsistencia = $this->bd->buscarAsistenciaAbierta($request->callback_query->from);
            $callback_query_id = $request->callback_query->id;

            if ($idAsistencia != 0) {
                if ($callback[0] == 'Complejidad') {
                    //actualiza complejidad
                    $this->bd->updateComplejidad($idAsistencia, $callback);
                    $this->sendAswerCallback($callback_query_id, 'Complejidad Actualizada');
                } elseif ($callback[0] == 'RangoEtario') {
                    //suma uno a tabla
                    $this->bd->updateVictima($idAsistencia, $callback);
                    $this->sendAswerCallback($callback_query_id, 'Victima Agregada');
                } elseif ($callback[0] == 'PrimerosAuxilios') {
                    $this->bd->updatePrimerosAuxilios($idAsistencia, $callback);
                    $this->sendAswerCallback($callback_query_id, 'Primeros Auxilios Agregados');
                } elseif ($callback[0] == 'Equipamiento') {
                    $this->bd->updateEquipamiento($idAsistencia, $callback);
                    $this->sendAswerCallback($callback_query_id, 'Equipamiento Agregado');
                }  elseif ($callback[0] == 'Puesto') {
                    $this->bd->updatePuesto($idAsistencia, $callback);
                    $this->sendAswerCallback($callback_query_id, 'Puesto Agregado');
                } 
elseif ($callback[0] == 'Guardar') {
                    $this->bd->updateEstadoAsistencia($idAsistencia, BD::ESTADO_CERRADA);
                    $this->sendMessage($request->callback_query->message->chat->id, 'Registro #' . $idAsistencia . ' Guardado');
                } elseif ($callback[0] == 'Cancelar') {
                    $this->bd->updateEstadoAsistencia($idAsistencia, BD::ESTADO_BAJA);
                    $this->sendMessage($request->callback_query->message->chat->id, 'Registro #' . $idAsistencia . ' Cancelado');
                }
            } else {
                $this->sendMessage($request->message->chat->id, 'No ha iniciado Asistencia /prevencion, /primerosauxilios o /rescate?');
            }
        } elseif (substr($request->message->text, 0, 6) == '/fecha' || in_array($request->message->text, ['/web', '/cerrar', '/start', '/novedad', '/prevencion', '/rescate', '/primerosauxilios','/resumens']) || isset($request->message->photo) || isset($request->message->voice) || isset($request->message->location)) {
            $idAsistencia = $this->bd->buscarAsistenciaAbierta($request->message->from);
            $balenario=$this->bd->buscarBalnearioActual($request->message->from);
            if($balenario!=null){
                $balenario=' Puesto en Balnerio '.$balenario['Balneario'].', ';
            }else{
                $balenario='';
            }
            if ($request->message->text == '/start') {
                $this->sendMessage($request->message->chat->id, 'Hola ' . $request->message->from->first_name);
                $this->sendMessage($request->message->chat->id, 'Este es el Chatbot de nix "el Libro de Aguas"');
                $this->sendMessage($request->message->chat->id, '/prevencion, /novedad, /primerosauxilios o /rescate?');
            } elseif ($request->message->text == '/cerrar') {
                $this->cerrarMsg($idAsistencia, $request);
            } elseif ($request->message->text == '/rescate') {
                /* Guarda Asistencia Vinculado al Guardavidas, Fecha, */
                if ($idAsistencia != 0) {
                    $this->sendMessage($request->message->chat->id, 'Tiene pendiente por cerrar un Registro');
                    $this->cerrarMsg($idAsistencia, $request);
                } else {
                    $this->bd->insertRescate($request->message->from,$fecha);

                    $this->sendMessage($request->message->chat->id, 'Complete Caracteristicas de Rescate, '.$balenario.'Comparta posición geográfica, foto y audio.', [$this->bd->getDescripcionesPuestos($request->message->from),$this->bd->getDescripciones('Complejidad'), $this->bd->getDescripciones('RangoEtario'),$this->bd->getDescripciones('Equipamiento','idTipoAsistencia='.BD::TIPO_RESCATE)/* , $this->bd->getDescripciones('PrimerosAuxilios') */]);
                }
            } elseif ($request->message->text == '/prevencion') {
                if ($idAsistencia != 0) {
                    $this->sendMessage($request->message->chat->id, 'Tiene pendiente por cerrar un Registro');
                    $this->cerrarMsg($idAsistencia, $request);
                } else {
                    $this->bd->insertAsistencia($request->message->from, BD::TIPO_PREVENCION,$fecha);
                    $this->sendMessage($request->message->chat->id, 'Complete Caracteristicas de Prevención, '.$balenario.'Comparta posición geográfica, foto y audio.', [$this->bd->getDescripcionesPuestos($request->message->from),$this->bd->getDescripciones('RangoEtario')]);
                }
            } elseif ($request->message->text == '/primerosauxilios') {
                if ($idAsistencia != 0) {
                    $this->sendMessage($request->message->chat->id, 'Tiene pendiente por cerrar un Registro');
                    $this->cerrarMsg($idAsistencia, $request);
                } else {
                    $this->bd->insertAsistencia($request->message->from, BD::TIPO_PRIMEROSAUXILIOS,$fecha);
                    $this->sendMessage($request->message->chat->id, 'Complete Caracteristicas de Primeros Auxilios, '.$balenario.' Comparta posición geográfica, foto y audio.', [$this->bd->getDescripcionesPuestos($request->message->from),$this->bd->getDescripciones('RangoEtario'), $this->bd->getDescripciones('PrimerosAuxilios')]);
                }
            } elseif ($request->message->text == '/novedad') {
                if ($idAsistencia != 0) {
                    $this->sendMessage($request->message->chat->id, 'Tiene pendiente por cerrar un Registro');
                    $this->cerrarMsg($idAsistencia, $request);
                } else {
                    $this->bd->insertAsistencia($request->message->from, BD::TIPO_NOVEDAD,$fecha);
                    $this->sendMessage($request->message->chat->id, 'Complete la Novedad, '.$balenario.' Comparta posición geográfica, foto y audio.',[$this->bd->getDescripcionesPuestos($request->message->from)]);
                }
            }
            // /resumenS resumen semanal
            elseif ($request->message->text == '/resumens') {
                    //$this->bd->buscarResumen($request->message->from,'S',$fecha);
                    $this->sendMessage($request->message->chat->id, 'Resumen Semanal: '.$balenario."\n"
                            . "Prevenciones:0 \n Asistencias:0 \n Rescates:0 \n Curaciones:0 \n Derivaciones:0");
                }
            
            // /resumenSC resumen semanal completo
    
             elseif (isset($request->message->photo) || isset($request->message->voice) || isset($request->message->location)) {

                if ($idAsistencia != 0) {
                    if (isset($request->message->photo)) {
                        $this->bd->insertArchivo($idAsistencia, $this->getFile($request->message->photo[0]->file_id, 'photos'));
                    } elseif (isset($request->message->voice)) {
                        $this->bd->insertArchivo($idAsistencia, $this->getFile($request->message->voice->file_id, 'voice'));
                    } elseif (isset($request->message->location)) {
                        $this->bd->updateLugar($idAsistencia, $request->message->location);
                    }
                    $this->sendMessage($request->message->chat->id, 'Alta archivo');
                } else {
                    $this->sendMessage($request->message->chat->id, 'No ha iniciado Asistencia /prevencion, /novedad, /primerosauxilios o /rescate?');
                }
            } elseif (substr($request->message->text, 0, 6) == '/fecha') {
                if ($idAsistencia != 0) {

                    //verificar que la fecha tenga parámetros Fecha

                    $this->bd->updateFecha($idAsistencia, substr($request->message->text, 7, strlen($request->message->text)));
                    $this->sendMessage($request->message->chat->id, 'Fecha Actualizada');
                } else {
                    $this->sendMessage($request->message->chat->id, 'No ha iniciado Asistencia /prevencion, /novedad, /primerosauxilios o /rescate?');
                }
            } elseif ($request->message->text == '/web') {
                $usuario = $this->bd->buscarUsuario($request->message->from);
                $this->sendMessage($request->message->chat->id, 'Ingrese a https://nix.fi.uncoma.edu.ar/index.php?r=site/login&LoginForm[username]='.str_replace(' ','%20', $usuario['Nombre'])  . '&LoginForm[password]=' . $usuario['idTelegram']);
            }
        } else {
            $idAsistencia = $this->bd->buscarAsistenciaAbierta($request->message->from);
            if ($idAsistencia != 0 && isset($request->message->text)) {
                $this->bd->updateObservacion($idAsistencia, $request->message->text);
            } else {
                $this->sendMessage($request->message->chat->id, 'Comando desconocido /prevencion, /novedad, /primerosauxilios o /rescate?');
            }
        }
    }

    function cerrarMsg($idAsistencia, $request) {
        if ($idAsistencia != 0) {
            $botones = [['text' => 'Guardar', 'callback_data' => 'Guardar' . '-' . $idAsistencia],
                    ['text' => 'Cancelar', 'callback_data' => 'Cancelar' . '-' . $idAsistencia]];
            $datos = $this->bd->mostrarAsistencia($idAsistencia);
            $this->sendMessage($request->message->chat->id, $datos, [$botones]);
        } else {
            $this->sendMessage($request->message->chat->id, 'No hay un registro abierto');
        }
    }

}
