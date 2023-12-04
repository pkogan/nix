<?php

namespace app\controllers;

use Yii;
use app\models\Asistencia;
use app\models\AsistenciaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * AsistenciaController implements the CRUD actions for Asistencia model.
 */
class AsistenciaController extends Controller
{
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
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'mapa','update','delete','create','resumen','libro'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'mapa','resumen','libro'],
                        'roles' => ['@'],
                    ],
                    
                ],
            ],
        ];
    }

     /**
     * Lists all Asistencia models.
     * @return mixed
     */
    public function actionMapa()
    {   
        $fieldName='Lugar';
        $asistencias = Asistencia::find()->where(['>=','Fecha','2023-12-01'])->all();
        //$asistencias = Asistencia::find()->all();
        

        return $this->render('mapa', [
            'asistencias' => $asistencias
        ]);
    }
    
    /**
     * Lists all Asistencia models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AsistenciaSearch();
        $params=Yii::$app->request->queryParams;
        if(!isset($params['AsistenciaSearch'])){
            $params['AsistenciaSearch']['dealerAvailableDate']='2023-12-01 - 2024-03-30';
        }
        $dataProvider = $searchModel->search($params);
       

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

        /**
     * Lists all Asistencia models.
     * @return mixed
     */
    public function actionLibro()
    {
        $searchModel = new AsistenciaSearch();
        $params=Yii::$app->request->queryParams;
        if(!isset($params['AsistenciaSearch'])){
            $params['AsistenciaSearch']['dealerAvailableDate']='2023-12-01 - 2024-03-30';
        }
        $dataProvider = $searchModel->search($params);
        //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('libro', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
        /**
     * Lists all Asistencia models.
     * @return mixed
     */
    public function actionResumen()
    {
        $searchModel = new AsistenciaSearch();
        $params=Yii::$app->request->queryParams;
        if(!isset($params['AsistenciaSearch'])){
            $params['AsistenciaSearch']['dealerAvailableDate']='2023-12-01 - 2024-03-30';
        }
        $dataProvider = $searchModel->searchResumen($params);

        //$dataProvider = $searchModel->searchResumen(Yii::$app->request->queryParams);

        return $this->render('resumen', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    
    /**
     * Displays a single Asistencia model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Asistencia model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Asistencia();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idAsistencia]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Asistencia model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idAsistencia]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Asistencia model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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
