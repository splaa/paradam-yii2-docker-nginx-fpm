<?php

namespace app\modules\services\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ServiceQuestionSearch represents the model behind the search form of `app\modules\services\models\ServiceQuestion`.
 */
class ServiceQuestionSearch extends ServiceQuestion
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['service_id', 'question_id'], 'integer'],
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
        $query = ServiceQuestion::find();

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
            'service_id' => $this->service_id,
            'question_id' => $this->question_id,
        ]);

        return $dataProvider;
    }
}
