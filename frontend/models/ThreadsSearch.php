<?php

namespace worstinme\forum\frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use worstinme\forum\frontend\models\Threads;

/**
 * ThreadsSearch represents the model behind the search form about `worstinme\forum\frontend\models\Threads`.
 */
class ThreadsSearch extends Threads
{
    public $_query;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'forum_id', 'flag', 'state', 'created_at', 'updated_at', 'user_id'], 'integer'],
            [['name', 'content'], 'safe'],
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
        $query = $this->_query !== null?$this->_query:Threads::find()->with(['forum','forum.section','lastPost']);

        if (Yii::$app->user->isGuest || !Yii::$app->user->can(Yii::$app->controller->module->moderRole)) {
            $query->where(['forum_threads.state'=>Threads::STATE_ACTIVE]);
        }

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query->orderBy('flag DESC, updated_at DESC'),
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
            'forum_id' => $this->forum_id,
            'flag' => $this->flag,
            'state' => $this->state,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'content', $this->content]);

        return $dataProvider;
    }
}
