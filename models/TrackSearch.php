<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Track;

/**
 * TrackSearch represents the model behind the search form of `app\models\Track`.
 */
class TrackSearch extends Track
{
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id', 'status'], 'integer'],
            [['track_number', 'created_at', 'updated_at'], 'safe'],
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
     * @param string|null $formName Form name to be used into `->load()` method.
     *
     * @return ActiveDataProvider
     */
    public function search($params, $formName = null)
    {
        $query = Track::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        if ($this->created_at) {
            $query->andWhere([
                'and',
                ['>=', 'created_at', strtotime(date('Y-m-d 00:00:00', strtotime($this->created_at)))],
                ['<=', 'created_at', strtotime(date('Y-m-d 23:59:59', strtotime($this->created_at)))]
            ]);
        }

        if ($this->updated_at) {
            $query->andWhere([
                'and',
                ['>=', 'updated_at', strtotime(date('Y-m-d 00:00:00', strtotime($this->updated_at)))],
                ['<=', 'updated_at', strtotime(date('Y-m-d 23:59:59', strtotime($this->updated_at)))]
            ]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'track_number', $this->track_number]);

        return $dataProvider;
    }
}
