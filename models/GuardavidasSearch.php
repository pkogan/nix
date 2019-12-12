<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Guardavidas;

/**
 * GuardavidasSearch represents the model behind the search form of `app\models\Guardavidas`.
 */
class GuardavidasSearch extends Guardavidas
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idGuardavidas', 'idRol'], 'integer'],
            [['Nombre', 'idTelegram', 'Mail'], 'safe'],
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
        $query = Guardavidas::find();

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
            'idGuardavidas' => $this->idGuardavidas,
            'idRol' => $this->idRol,
        ]);

        $query->andFilterWhere(['like', 'Nombre', $this->Nombre])
            ->andFilterWhere(['like', 'idTelegram', $this->idTelegram])
            ->andFilterWhere(['like', 'Mail', $this->Mail]);

        return $dataProvider;
    }
}
