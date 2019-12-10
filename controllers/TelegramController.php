<?php

namespace app\controllers;

use Yii;
use app\models\Asistencia;
use app\models\AsistenciaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
//use yii\filters\AccessControl;

/**
 * AsistenciaController implements the CRUD actions for Asistencia model.
 */
class TelegramController extends Controller
{


    private $TOKEN='707416034:AAF5msJweymVO3FUKvs41g8w2pgvy4YIlpo';
    private $file_log = 'registro_de_nix.log';    

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
//            'access' => [
//                'class' => AccessControl::className(),
//                'only' => ['index', 'view', 'mapa','update','delete','create'],
//                'rules' => [
//                    [
//                        'allow' => true,
//                        'actions' => ['index', 'view', 'mapa'],
//                        'roles' => ['@'],
//                    ],
//                    
//                ],
//            ],
        ];
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
    public function procesarBotones($buttons){
        //se divide en lineas de a 4 botones
        $botones4=[];
        $row=[];
        foreach ($buttons as  $rowActual) {
            foreach ($rowActual as $key =>$value){
                if($key==4){
                    $botones4[]=$row;
                    $row=[];
                }
                $row[]=$value;
            }
            if(count($row)>0){
                $botones4[]=$row;
                $row=[];
            }
        }
        return $botones4;
    }
    public function sendMessage($chatId, $text, $buttons = null) {
        /**
          Para setear en webhook hay que:
          https://api.telegram.org/bot707416034:AAF5msJweymVO3FUKvs41g8w2pgvy4YIlpo/setWebHook?url=https://nix.fi.uncoma.edu.ar/bot/707416034:AAF5msJweymVO3FUKvs41g8w2pgvy4YIlpo.php
         */
//  $TOKEN = "864869954:AAHMEn8FoLsGjpObOAGuzzojlQMheF5scy0";
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
    

    
    /**
     * Lists all Asistencia models.
     * @return mixed
     */
    public function actionIndex()
    {
       $request = file_get_contents("php://input");
       $this->procesar($request);
    }
    
    function procesar($request) {

        $fecha = date('Y-m-d H:i:s');
//echo noticias();

        file_put_contents($this->file_log, $fecha . ' - ' . $request, FILE_APPEND);
        $request = json_decode($request);
        $this->sendMessage($request->message->chat->id, 'Hola ' . $request->message->from->first_name);
    }

    /**
     * Finds the Asistencia model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Asistencia the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Asistencia::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
