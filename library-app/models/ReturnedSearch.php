<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ReturnedBook;

/**
 * ReturnedSearch represents the model behind the search form of `app\models\ReturnedBook`.
 */
class ReturnedSearch extends ReturnedBook
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'taken_book_id', 'count'], 'integer'],
            [['return_date', 'pick_up_date'], 'safe'],
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
    public function search($params, $user_id)
    {
        $query = ReturnedBook::find()->where(['user_id' => $user_id]);

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
            'user_id' => $this->user_id,
            'taken_book_id' => $this->taken_book_id,
            'count' => $this->count,
            'return_date' => $this->return_date,
            'pick_up_date' => $this->pick_up_date,
        ]);

        return $dataProvider;
    }
}
