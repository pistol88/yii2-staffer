<?php
namespace pistol88\staffer\models\fine;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use pistol88\staffer\models\Fine;

/**
 * FineSearch represents the model behind the search form about `pistol88\staffer\models\Fine`.
 */
class FineSearch extends Fine
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'staffer_id'], 'integer'],
            [['reason', 'comment', 'created_at'], 'safe'],
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

    public function search($params)
    {
        $query = Fine::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
            'sort' => new \yii\data\Sort([
                'attributes' => [
                    'id', 'sum', 'created_at'
                ],
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ]
            ])
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
			'staffer_id' => $this->staffer_id,
        ]);

        $query->andFilterWhere(['like', 'reason', $this->reason]);
        $query->andFilterWhere(['like', 'comment', $this->comment]);
        $query->andFilterWhere(['like', 'created_at', $this->created_at]);
        
        return $dataProvider;
    }
}
