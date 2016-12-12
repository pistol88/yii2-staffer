<?php
namespace pistol88\staffer\widgets;

use yii\helpers\Html;
use pistol88\staffer\models\DebtTransactions;
use yii;

class ReturnDebt extends \yii\base\Widget
{
    public $worker = null; // instance of pistol88\staffer\models\Staffer

    public function init()
    {
        \pistol88\staffer\assets\AddDebtAsset::register($this->getView());

        return parent::init();

    }

    public function run()
    {
        $model = new DebtTransactions;
        $sessionId = 0;
        if (\Yii::$app->has('worksess') && $session = yii::$app->worksess->soon()) {
            $sessionId = $session->id;
        }

        $totalDebt = 0;
        $lastDebt = DebtTransactions::find()
                        ->where(['worker_id' => $this->worker->id])
                        ->orderBy(['id' => SORT_DESC])
                        ->one();

        if ($lastDebt) {
            $totalDebt = $lastDebt->balance;
        }

        return $this->render('return_debt', [
            'model' => $model,
            'sessionId' => $sessionId,
            'staffer' => $this->worker,
            'totalDebt' => $totalDebt
        ]);
    }
}
