<?php
namespace pistol88\staffer\widgets;

use yii\helpers\Html;
use pistol88\staffer\models\Payment;
use pistol88\staffer\models\payment\PaymentSearch;
use yii\data\ActiveDataProvider;
use yii;

class WorkerSalary extends \yii\base\Widget
{
    public $workerId = null;

    public function init()
    {
        \pistol88\staffer\assets\WidgetAsset::register($this->getView());

        return parent::init();
    }

    public function run()
    {
        $sessionsQuery = \Yii::$app->worksess->getUserSessions($this->workerId);

        $dataProvider = new ActiveDataProvider([
            'query' => $sessionsQuery,
        ]);

        return $this->render('worker_salary', [
            'dataProvider' => $dataProvider
        ]);
    }
}
