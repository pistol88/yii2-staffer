<?php
namespace pistol88\staffer\models\payment;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use pistol88\service\models\Payment;

class PaymentSearch extends Payment
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'session_id', 'worker_id', 'client_id'], 'integer'],
            [['sum'], 'safe'],
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
        $query = Payment::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'worker_id' => $this->worker_id,
            'client_id' => $this->client_id,
            'user_id' => $this->user_id,
            'session_id' => $this->session_id,
        ]);

        $query->andFilterWhere(['like', 'sum', $this->sum]);

        return $dataProvider;
    }
}
