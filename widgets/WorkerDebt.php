<?php
namespace pistol88\staffer\widgets;

use yii\helpers\Html;
use pistol88\staffer\models\DebtTransactions;
use yii\data\ActiveDataProvider;
use yii;

class WorkerDebt extends \yii\base\Widget
{
    public $worker = null;

    public function init()
    {
        \pistol88\staffer\assets\AddDebtAsset::register($this->getView());

        return parent::init();
    }

    public function run()
    {
        // $sessionsQuery = $this->worker->getSalary();

        // if ($dateStart = \Yii::$app->request->get('date_start')) {
        //     $sessionsQuery->andWhere(['>=', 'date', date('Y-m-d', strtotime($dateStart))]);
        // }
        //
        // if ($dateStop = \Yii::$app->request->get('date_stop')) {
        //     $sessionsQuery->andWhere(['<=', 'date', date('Y-m-d H:i:s', strtotime($dateStop) + 86399)]);
        // }
        $totalDebt = 0;
        $lastDebt = DebtTransactions::find()
                        ->where(['worker_id' => $this->worker->id])
                        ->orderBy(['id' => SORT_DESC])
                        ->one();

        if ($lastDebt) {
            $totalDebt = $lastDebt->balance;
        }


        $query = DebtTransactions::find()->where(['worker_id' => $this->worker->id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder'=> ['id' => SORT_DESC]],
            'pagination' => [
                'pageSize' => 50,
            ],
        ]);


        return $this->render('worker_debt', [
            'dataProvider' => $dataProvider,
            'worker' => $this->worker,
            'totalDebt' => $totalDebt,
        ]);
    }
}
