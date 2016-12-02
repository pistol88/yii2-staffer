<?php
namespace pistol88\staffer\widgets;

use yii\helpers\Html;
use pistol88\staffer\models\Payment;
use pistol88\staffer\models\DebtTransactions;
use pistol88\staffer\models\payment\PaymentSearch;
use kartik\select2\Select2;
use yii;

class AddPayment extends \yii\base\Widget
{
    public $staffer = null; // instance of pistol88\staffer\models\Staffer
    public $paymentSum = null;
    public $sessionId = null;

    public function init()
    {
        \pistol88\staffer\assets\AddPaymentAsset::register($this->getView());
        \pistol88\staffer\assets\AddDebtAsset::register($this->getView());

        return parent::init();
    }

    public function run()
    {
        $lastPayments = Payment::find()
                                    ->where(['worker_id' => $this->staffer->id, 'session_id' => $this->sessionId])
                                    ->orderBy(['date' => SORT_DESC])
                                    ->all();

        $debt = 0;
        $debts = DebtTransactions::find()
                                    ->where(['worker_id' => $this->staffer->id])
                                    ->orderBy(['date' => SORT_DESC])
                                    ->one();

        if ($debts && $debts != 0) {
            $debt = $debts->balance;
        }

        $model = new Payment;

        return $this->render('add_payment', [
            'model' => $model,
            'paymentSum' => $this->paymentSum,
            'sessionId' => $this->sessionId,
            'staffer' => $this->staffer,
            'lastPayments' => $lastPayments,
            'debt' => $debt
        ]);
    }
}
