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

    public function actionIndex($date = null)
    {
        if(!$date) {
            $date = date('Y-m-d');
        } else {
            $date = date('Y-m-d', strtotime($date));
        }
        
        $staffers = Staffer::find()->where(['status' => 'active'])->all();
        
        $dateStart = date('Y-m-d', strtotime($date)-($this->module->salaryPeriodDays*86400));
        $dateStop = $date;
        
        $sessions = yii::$app->worksess->getSessionsByDatePeriod($dateStart, $dateStop);

        return $this->render('index', [
            'dateStart' => $dateStart,
            'dateStop' => $dateStop,
            'staffers' => $staffers,
            'sessions' => $sessions,
            'module' => $this->module,
        ]);
    }
}
