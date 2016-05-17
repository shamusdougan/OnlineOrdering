<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\emailQueue;

/**
 * emailQueueSearch represents the model behind the search form about `app\models\emailQueue`.
 */
class emailQueueSearch extends emailQueue
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['from', 'to', 'subject', 'htmlBody', 'attachment1', 'attachment1_filename', 'attachment1_type', 'attachment2', 'attachment2_filename', 'attachment2_type'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = emailQueue::find();

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
        ]);

        $query->andFilterWhere(['like', 'from', $this->from])
            ->andFilterWhere(['like', 'to', $this->to])
            ->andFilterWhere(['like', 'subject', $this->subject])
            ->andFilterWhere(['like', 'htmlBody', $this->htmlBody])
            ->andFilterWhere(['like', 'attachment1', $this->attachment1])
            ->andFilterWhere(['like', 'attachment1_filename', $this->attachment1_filename])
            ->andFilterWhere(['like', 'attachment1_type', $this->attachment1_type])
            ->andFilterWhere(['like', 'attachment2', $this->attachment2])
            ->andFilterWhere(['like', 'attachment2_filename', $this->attachment2_filename])
            ->andFilterWhere(['like', 'attachment2_type', $this->attachment2_type]);

        return $dataProvider;
    }
}
