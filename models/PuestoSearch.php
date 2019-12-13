<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Puesto;

/**
 * PuestoSearch represents the model behind the search form of `app\models\Puesto`.
 */
class PuestoSearch extends Puesto
{
    public $balneario;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idPuesto', 'idBalneario'], 'integer'],
            [['Nombre', 'Lugar','balneario'], 'safe'],
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
        $query = Puesto::find()->innerJoinWith('idBalneario0');

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
            'idPuesto' => $this->idPuesto,
            'idBalneario' => $this->idBalneario,
        ]);

        $query->andFilterWhere(['like', 'Puesto.Nombre', $this->Nombre])
            ->andFilterWhere(['like', 'Lugar', $this->Lugar])
            ->andFilterWhere(['like','Balneario.Nombre',$this->balneario]);

        return $dataProvider;
    }
}
