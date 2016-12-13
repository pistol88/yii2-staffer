<?php
namespace pistol88\staffer;

use yii\base\Component;
use pistol88\staffer\events\PaymentEvent;
use pistol88\staffer\events\DebtEvent;
use pistol88\staffer\events\BonusEvent;
use pistol88\staffer\models\Payment;
use pistol88\staffer\models\Bonus;
use pistol88\staffer\models\DebtTransactions;
use pistol88\staffer\models\Staffer as StafferModel;
use yii;

class Staffer extends Component
{
    public $finder = null;

    public function init()
    {
        $this->finder = StafferModel::find();

        parent::init();
    }

    public function status($status)
    {
        $this->finder->andWhere(['status' => $status]);

        return $this;
    }

    public function all()
    {
        return $this->finder->all();
    }

    public function one()
    {
        return $this->finder->one();
    }

    public function addPayment($workerId, $sum, $sessionId)
    {
        $payment = new Payment;
        $payment->worker_id = $workerId;
        $payment->sum = $sum;
        $payment->session_id = $sessionId;
        $payment->user_id = Yii::$app->user->id;
        $payment->date = date('Y-m-d H:i:s');
        $payment->date_timestamp = time();

        if($payment->validate() && $payment->save()) {

            $module = \Yii::$app->getModule('staffer');
            $paymentEvent = new PaymentEvent(['model' => $payment]);
            $module->trigger($module::EVENT_PAYMENT_CREATE, $paymentEvent);

            return $payment->id;
        } else {
            return false;
        }
    }

    public function removePayment($id)
    {
        $payment = Payment::findOne($id);
        if ($payment) {
            $module = \Yii::$app->getModule('staffer');
            $paymentEvent = new PaymentEvent(['model' => $payment]);
            if ($payment->delete()) {
                $module->trigger($module::EVENT_PAYMENT_REMOVE, $paymentEvent);
            }
            return true;
        } else {
            return true;
        }
    }

    public function addDebtTransaction($stafferId, $sum, $sessionId, $type)
    {
        $balance = 0;

        $lastDebt = DebtTransactions::find()
                        ->where(['worker_id' => $stafferId])
                        ->orderBy(['id' => SORT_DESC])
                        ->one();
        if ($lastDebt) {
            $balance = $lastDebt->balance;
        }

        $debt = new DebtTransactions;
        $debt->worker_id = $stafferId;
        $debt->sum = $sum;
        $debt->type = $type;
        $debt->session_id = $sessionId;
        $debt->user_id = Yii::$app->user->id;
        $debt->date = date('Y-m-d H:i:s');

        if ($type === 'given') {
            $balance += $sum;
        } else {
            $balance -= $sum;
        }

        $debt->balance = $balance;

        if($debt->save()) {

            $module = \Yii::$app->getModule('staffer');
            $debtEvent = new DebtEvent(['model' => $debt]);
            $module->trigger($module::EVENT_DEBT_CREATE, $debtEvent);

            return $debt->id;
        } else {
            return false;
        }


    }

    public function getStafferPaymentsBySession($stafferId, $sessionId)
    {
        return Payment::find()
                ->where(['worker_id' => $stafferId, 'session_id' => $sessionId])
                ->orderBy(['date' => SORT_DESC]);
    }

    public function getStafferDebtsBySession($stafferId, $sessionId, $type = null)
    {
        $query = DebtTransactions::find()
                ->where(['worker_id' => $stafferId, 'session_id' => $sessionId]);

         if ($type) {
            $query->andWhere(['type' => $type]);
         }
        return $query->orderBy(['date' => SORT_DESC]);
    }

    public function getStafferDebts($stafferId, $type = null)
    {
        $query = DebtTransactions::find()
                ->where(['worker_id' => $stafferId]);

         if ($type) {
            $query->andWhere(['type' => $type]);
         }
        return $query->orderBy(['date' => SORT_DESC]);
    }

    public function addBonus($stafferId, $sum, $reason, $comment = null)
    {
        $bonusModel = new Bonus;

        $bonusModel->staffer_id = $stafferId;
        $bonusModel->sum = $sum;
        $bonusModel->reason = $reason;

        $bonusModel->comment = $comment;

        $bonusModel->created = date('Y-m-d H:i:s');
        $bonusModel->user_id = \Yii::$app->user->id;

        if ($bonusModel->save()) {

            $module = \Yii::$app->getModule('staffer');
            $bonusEvent = new BonusEvent(['model' => $bonusModel]);
            $module->trigger($module::EVENT_BONUS_CREATE, $bonusEvent);

            return $bonusModel->id;

        } else {
            return false;
        }

    }

    public function cancelBonus($bonusId)
    {
        $bonusModel = Bonus::findOne($bonusId);

        if (!$bonusModel) {
            return false;
        }

        if ($bonusModel->canceled || $bonusModel->payed) {
            return false;
        }

        $bonusModel->canceled = date('Y-m-d H:i:s');
        $bonusModel->canceled_user_id = \Yii::$app->user->id;

        if ($bonusModel->save()) {

            $module = \Yii::$app->getModule('staffer');
            $bonusEvent = new BonusEvent(['model' => $bonusModel]);
            $module->trigger($module::EVENT_BONUS_CANCEL, $bonusEvent);

            return $bonusModel->id;

        } else {
            return false;
        }

    }

    public function getStafferBonuses($stafferId)
    {
        return Bonus::find()->where(['staffer_id' => $stafferId])->andWhere(['canceled' => null]);
    }

}
