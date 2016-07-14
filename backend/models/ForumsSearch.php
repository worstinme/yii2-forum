<?php

namespace worstinme\forum\backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use worstinme\forum\backend\models\Forums;

/**
 * ForumsSearch represents the model behind the search form about `worstinme\forum\backend\models\Forums`.
 */
class ForumsSearch extends Forums
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'section_id', 'state', 'sort'], 'integer'],
            [['name', 'alias', 'description', 'metaTitle', 'metaDescription', 'metaKeywords'], 'safe'],
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
        $query = Forums::find();

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
            'section_id' => $this->section_id,
            'state' => $this->state,
            'sort' => $this->sort,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'alias', $this->alias])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'metaTitle', $this->metaTitle])
            ->andFilterWhere(['like', 'metaDescription', $this->metaDescription])
            ->andFilterWhere(['like', 'metaKeywords', $this->metaKeywords]);

        return $dataProvider;
    }
}
