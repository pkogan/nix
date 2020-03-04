<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Asistencia;

/**
 * AsistenciaSearch represents the model behind the search form of `app\models\Asistencia`.
 */
class AsistenciaSearch extends Asistencia {

    public $guardavidas;
    public $tipo;
    public $puesto;
    public $dealerAvailableDate;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
                [['idAsistencia', 'idGuardavidas', 'idTipo', 'idEstadoAsistencia'], 'integer'],
                [['Fecha', 'Lugar', 'guardavidas', 'tipo', 'puesto', 'dealerAvailableDate', 'Observacion'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios() {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params) {

        $query = Asistencia::find()->innerJoinWith('idTipo0')->joinWith('idPuesto0');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['idAsistencia' => SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'idAsistencia' => $this->idAsistencia,
            'Asistencia.idGuardavidas' => $this->idGuardavidas,
            'Fecha' => $this->Fecha,
            'idTipo' => $this->idTipo,
            'idEstadoAsistencia' => $this->idEstadoAsistencia,
        ]);

        $query->andFilterWhere(['like', 'Lugar', $this->Lugar])
                ->andFilterWhere(['like', 'Observacion', $this->Observacion])
                ->andFilterWhere(['like', 'Guardavidas.Nombre', $this->guardavidas])
                ->andFilterWhere(['like', 'TipoAsistencia.Descripcion', $this->tipo])
                ->andFilterWhere(['like', 'Puesto.Nombre', $this->puesto]);


        if (isset($this->dealerAvailableDate) && $this->dealerAvailableDate != '') { //you dont need the if function if yourse sure you have a not null date
            $date_explode = explode(" - ", $this->dealerAvailableDate);
            $date1 = trim($date_explode[0]);
            $date2 = trim($date_explode[1]);
            $query->andFilterWhere(['between', 'Fecha', $date1, $date2]);
        }

        return $dataProvider;
    }

    public function searchResumen($params) {

        $query = Asistencia::find()->innerJoinWith('idTipo0')->joinWith('idPuesto0')->joinWith('victimas');
        $query->groupBy(['Puesto.Nombre', 'Asistencia.idTipo']);
        $query->select(['Puesto.Nombre', 'TipoAsistencia.Descripcion', 'Count(*) as Count', 'Sum(Victima.Cantidad) as Cantidad']);
        // add conditions that should always apply here



        $this->load($params);

        /*if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            $dataProvider = new \yii\data\ArrayDataProvider([
                'allModels' => $query->asArray()->all(),
            ]);
            return $dataProvider;
        }*/

        // grid filtering conditions
        $query->andFilterWhere([
            //'idAsistencia' => $this->idAsistencia,
            'Asistencia.idGuardavidas' => $this->idGuardavidas,
            //'Fecha' => $this->Fecha,
            'Asistencia.idTipo' => $this->idTipo,
            'idEstadoAsistencia' => $this->idEstadoAsistencia,
        ]);

        $query->andFilterWhere(['like', 'Puesto.Nombre', $this->puesto]);


        if (isset($this->dealerAvailableDate) && $this->dealerAvailableDate != '') { //you dont need the if function if yourse sure you have a not null date
            $date_explode = explode(" - ", $this->dealerAvailableDate);
            $date1 = trim($date_explode[0]);
            $date2 = trim($date_explode[1]);
            $query->andFilterWhere(['between', 'Fecha', $date1, $date2]);
        }
        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $query->asArray()->all(),
        ]);
        return $dataProvider;
    }

}
