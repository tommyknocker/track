<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ActionLogSearch represents the model behind the search form of `app\models\ActionLog`.
 */
class ActionLogSearch extends ActionLog
{
    public function rules(): array
    {
        return [
            [['id', 'entity_id', 'user_id', 'action_id'], 'integer'],
            [['entity', 'old_state', 'new_state', 'created_at'], 'safe'],
        ];
    }

    public function scenarios(): array
    {
        return Model::scenarios();
    }

    public function search(array $params): ActiveDataProvider
    {
        $query = ActionLog::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        if ($this->created_at) {
            $query->andWhere(['>=', 'created_at', strtotime(date('Y-m-d 00:00:00', strtotime($this->created_at)))]);
            $query->andWhere(['<=', 'created_at', strtotime(date('Y-m-d 23:59:59', strtotime($this->created_at)))]);
        }


        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'entity_id' => $this->entity_id,
            'action_id' => $this->action_id,
            'user_id' => $this->user_id,
            'entity' => $this->entity
        ]);

        return $dataProvider;
    }
}
