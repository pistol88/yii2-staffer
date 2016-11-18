<?php
namespace pistol88\staffer;

use yii\base\Component;
use pistol88\staffer\events\PaymentEvent;
use pistol88\staffer\models\Payment;
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
    public function getStafferPaymentsBySession($stafferId, $sessionId)
    {
        return Payment::find()
                ->where(['worker_id' => $stafferId, 'session_id' => $sessionId])
                ->orderBy(['date' => SORT_DESC]);
    }

}
