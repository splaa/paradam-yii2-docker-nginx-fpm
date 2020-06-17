<?php

namespace app\modules\admin\models;

use app\modules\services\models\OrderService;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * OrderServiceSearch represents the model behind the search form of `app\modules\admin\models\OrderService`.
 */
class OrderServiceSearch extends OrderService
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'customer_id', 'executor_id', 'service_id', 'status', 'amount'], 'integer'],
            [['answers', 'comment', 'created_at', 'updated_at'], 'safe'],
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
        $query = OrderService::find();

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
            'id' => $this->id,
            'customer_id' => $this->customer_id,
            'executor_id' => $this->executor_id,
            'service_id' => $this->service_id,
            'status' => $this->status,
            'amount' => $this->amount,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'answers', $this->answers])
            ->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
}
