<?php

namespace app\controllers;

use Yii;
use app\models\Puesto;
use app\models\PuestoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\AccessRule;

/**
 * PuestoController implements the CRUD actions for Puesto model.
 */
class PuestoController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                // We will override the default rule config with the new AccessRule class
                'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],
                'only' => ['index', 'create', 'update', 'delete', 'creardesdeasistencia'],
                'rules' => [
                        [
                        'actions' => ['index', 'create', 'update', 'delete', 'creardesdeasistencia'],
                        'allow' => true,
                        // Allow users, moderators and admins to create
                        'roles' => [
                            \app\models\Asistencia::ROL_ADMIN
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Puesto models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new PuestoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Puesto model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Puesto model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreardesdeasistencia($id) {
        /**
         * @var \app\models\Asistencia Description
         */
        $asistencia = \app\models\Asistencia::find()->andWhere('idAsistencia=' . $id)->one();
        //print_r($asistencia);
        if (!is_null($asistencia)) {
            $model = new Puesto();
            $model->Nombre=$asistencia->Observacion;
            $model->latitude=$asistencia->latitude;
            $model->longitude=$asistencia->longitude;
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->idPuesto]);
            }

            return $this->render('create', [
                        'model' => $model,
            ]);
        } else {
            throw new \yii\base\ErrorException('No existe Asistencia');
        }
    }

    /**
     * Creates a new Puesto model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Puesto();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idPuesto]);
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing Puesto model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        print_r(Yii::$app->request->post());
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idPuesto]);
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Puesto model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Puesto model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Puesto the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Puesto::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
