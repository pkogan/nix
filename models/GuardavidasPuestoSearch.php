<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\GuardavidasPuesto;

/**
 * GuardavidasPuestoSearch represents the model behind the search form of `app\models\GuardavidasPuesto`.
 */
class GuardavidasPuestoSearch extends GuardavidasPuesto
{
    public $guardavidas;
    public $balneario;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idGuardavidasPuesto', 'idGuardavidas', 'idPuesto'], 'integer'],
            [['Fecha','guardavidas','balneario'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
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
    public function search($params)
    {
        $query = GuardavidasPuesto::find()->innerJoinWith('idGuardavidas0')->innerJoinWith('idPuesto0')->innerJoinWith('idPuesto0.idBalneario0');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'idGuardavidasPuesto' => $this->idGuardavidasPuesto,
            'idGuardavidas' => $this->idGuardavidas,
            'idPuesto' => $this->idPuesto,
            'Fecha' => $this->Fecha,
        ]);
        $query->andFilterWhere(['like', 'Guardavidas.Nombre', $this->guardavidas])
             ->andFilterWhere(['like', 'Balneario.Nombre', $this->balneario]);

        return $dataProvider;
    }
}
