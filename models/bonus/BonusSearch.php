<?php
namespace pistol88\staffer\models\category;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use pistol88\staffer\models\Bonus;

/**
 * BonusSearch represents the model behind the search form about `common\models\Bonus`.
 */
class BonusSearch extends Bonus
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'staffer_id', 'user_id'], 'integer'],
            [['reason', 'comment', 'created', 'canceled'], 'safe'],
            [['sum'], 'number'],
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
        $query = Bonus::find();

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
            'staffer_id' => $this->staffer_id,
            'user_id' => $this->user_id,
            'sum' => $this->sum,
            'created' => $this->created,
            'canceled' => $this->canceled,
        ]);

        $query->andFilterWhere(['like', 'reason', $this->reason])
            ->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
}
