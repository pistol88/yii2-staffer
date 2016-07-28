<?php
namespace pistol88\staffer\models\staffer;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use pistol88\staffer\models\Staffer;

class StafferSearch extends Staffer
{
    public function rules()
    {
        return [
            [['id', 'category_id'], 'integer'],
            [['name', 'text', 'status'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Staffer::scenarios();
    }

    public function search($params)
    {
        $query = Staffer::find();
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => new \yii\data\Sort([
                'attributes' => [
                    'name',
                    'status',
                    'id',
                ],
            ])
        ]);
        
        $dataProvider->sort = ['defaultOrder' => ['id' => SORT_DESC]];

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'category_id' => $this->category_id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'text', $this->text]);

        return $dataProvider;
    }
}
