<?php

namespace common\models\search;

use common\models\AppleStatus;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Apple;

class AppleSearch extends Apple
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'integrity', 'status_id'], 'integer'],
            [['color', 'date_created', 'date_drop'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
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
        $query = Apple::find()
            ->innerJoin('apple_status', 'apple_status.id = apple.status_id');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {

            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query
            ->andFilterWhere(['=', 'integrity', $this->integrity])
            ->andFilterWhere(['=', 'status_id', $this->status_id])
            ->andFilterWhere(['=', 'apple_status.id', $this->status_id])
            ->andFilterWhere((['=', 'DATE(date_created)', $this->date_created]))
            ->andFilterWhere((['=', 'DATE(date_drop)', $this->date_drop]))
            ->andFilterWhere(['ilike', 'color', $this->color]);

        return $dataProvider;
    }

    public function searchExceptRotten($params)
    {
        $query = Apple::find()
            ->innerJoin('apple_status', 'apple_status.id = apple.status_id')
            ->andWhere(['NOT', ['status_id' => AppleStatus::getIdByCode(AppleStatus::ROTTEN)]]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {

            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query
            ->andFilterWhere(['=', 'integrity', $this->integrity])
            ->andFilterWhere(['=', 'status_id', $this->status_id])
            ->andFilterWhere(['=', 'apple_status.id', $this->status_id])
            ->andFilterWhere((['=', 'DATE(date_created)', $this->date_created]))
            ->andFilterWhere((['=', 'DATE(date_drop)', $this->date_drop]))
            ->andFilterWhere(['ilike', 'color', $this->color]);

        return $dataProvider;
    }
}
