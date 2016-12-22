<?php
namespace pistol88\staffer\widgets;

use yii\helpers\Html;
use pistol88\staffer\models\DebtTransactions;
use yii;

class AddDebt extends \yii\base\Widget
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
        $userOnSession = false;
        if (\Yii::$app->has('worksess') && $session = yii::$app->worksess->soon()) {
            $sessionId = $session->id;
            $userOnSession = $session->getOpenedUserSessions()->andWhere(['user_id' => $this->worker->id])->all();
        }

        if ($userOnSession) {
            return $this->render('add_debt', [
                'model' => $model,
                'sessionId' => $sessionId,
                'staffer' => $this->worker,
            ]);
        } else {
            return "<p>Не на смене</p>";
        }


    }
}
