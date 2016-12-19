<?php
namespace pistol88\staffer\controllers;

use Yii;
use pistol88\staffer\models\Staffer;
use pistol88\staffer\models\Payment;
use pistol88\staffer\models\category\PaymentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class SalaryController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => $this->module->adminRoles,
                    ]
                ]
            ],
        ];
    }

    public function actionIndex()
    {
        $staffers = Staffer::find()->where(['status' => 'active'])->all();
        
        $sessions = yii::$app->worksess->getSessionsByDatePeriod(date('Y').'-'.date('m').'-'.$this->module->salaryPeriodDayStart, date('Y').'-'.date('m').'-'.$this->module->salaryPeriodDayStop);
        
        $dateStart = $this->module->salaryPeriodDayStart.'.'.date('m').'.'.date('Y');
        $dateStop = $this->module->salaryPeriodDayStop.'.'.date('m').'.'.date('Y');
        
        return $this->render('index', [
            'dateStart' => $dateStart,
            'dateStop' => $dateStop,
            'staffers' => $staffers,
            'sessions' => $sessions,
            'module' => $this->module,
        ]);
    }
}
