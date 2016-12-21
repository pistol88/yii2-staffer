<?php
namespace pistol88\staffer\controllers;

use Yii;
use pistol88\staffer\models\Payment;
use pistol88\staffer\models\category\PaymentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class PaymentController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'add' => ['post', 'get'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
				'only' => ['add', 'index', 'add-period-ajax', 'remove-ajax', 'add-ajax'],
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
        echo 'test';
    }

    public function actionAddPeriodAjax()
    {
        $data = yii::$app->request->post();

        $stafferId = $data['stafferId'];
        
        $status = 'fail';

        if($data['sumToSalary'] > 0) {
            $sessions = $data['allSessions'];
            $salarySum = $data['sumToSalary'];
            if($salarySum > 0) {
                $uselessPull = [];
                
                foreach($sessions as $sessionId => $sum) {
                    if($salarySum > 0 && $sum > 0) {
                        if($sum >= $salarySum) {
                            $paymentId = Yii::$app->staffer->addPayment($stafferId, $salarySum, $sessionId);
                            $salarySum = $salarySum-$sum;
                        } else {
                            $uselessPull[$sessionId] = $sum;
                        }
                    } else {
                        $uselessPull[$sessionId] = $sum;
                    }
                }
                
                if($salarySum > 0) {
                    foreach($uselessPull as $sessionId => $sum) {
                        if($salarySum > 0 && $sum > 0) {
                            if($salarySum < $sum) {
                                $paymentId = Yii::$app->staffer->addPayment($stafferId, $salarySum, $sessionId);
                                $salarySum = 0;
                            } else {
                                $paymentId = Yii::$app->staffer->addPayment($stafferId, $sum, $sessionId);
                                $salarySum = $salarySum-$sum;
                            }
                        }
                    }
                }
                
                if($salarySum > 0) {
                    Yii::$app->staffer->addBonus($stafferId, $salarySum, 'Распределение суммы ЗП '.date('d.m.Y H:i'));
                }
                
                $status = 'success';
            }
        } elseif($data['session']) {
            $sessions = $data['session'];

            foreach($sessions as $sessionId => $sum) {
                $sum = $data['sum'][$sessionId];
                $paymentId = Yii::$app->staffer->addPayment($stafferId, $sum, $sessionId);

                if ($paymentId) {
                    $status = 'success';
                } else {
                    return json_encode([
                        'status' => 'error'
                    ]);
                }
            }
        }
        
        return json_encode([
            'status' => $status
        ]);
    }
    
    public function actionAddAjax()
    {

        $data = yii::$app->request->post();

        $stafferId = $data['stafferId'];
        $sessionId = $data['sessionId'];
        $sum = $data['sum'];

        $paymentId = Yii::$app->staffer->addPayment($stafferId, $sum, $sessionId);

        if ($paymentId) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            return [
                'status' => 'success',
                'paymentId' => $paymentId
            ];
        } else {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'status' => 'error'
            ];
        }
    }

    public function actionRemoveAjax()
    {
        $paymentId = (int)yii::$app->request->post('paymentId');

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if ($paymentId = Yii::$app->staffer->removePayment($paymentId)) {
            return [
                'status' => 'success'
            ];
        } else {
            return [
                'status' => 'error'
            ];
        }

    }

}
