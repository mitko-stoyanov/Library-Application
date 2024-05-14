<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TakenBook;

/**
 * TakenSearch represents the model behind the search form of `app\models\TakenBook`.
 */
class TakenSearch extends TakenBook
{
    /**
     * {@inheritdoc}
     */

    public $globalSearch;

    public function rules()
    {
        return [
            [['id', 'user_id', 'book_id', 'count'], 'integer'],
            [['pick_up_date', 'globalSearch', 'return_date'], 'safe'],
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
        $query = TakenBook::find()->where(['user_id' => $user_id])->joinWith(['book', 'user']);

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
        
        $query->orFilterWhere(['like', 'user_id', $this->globalSearch])
            ->orFilterWhere(['like', 'book_id', $this->globalSearch]);

        return $dataProvider;
    }
}
