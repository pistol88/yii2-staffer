<?php
namespace pistol88\staffer\controllers;

use Yii;
use pistol88\staffer\models\Staffer;
use pistol88\staffer\models\Salary;
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

    public function actionIndex($date = null, $dateStop = null)
    {
        if($dateStop) {
            $dateStart  = date('Y-m-d', strtotime($date));
            $dateStop  = date('Y-m-d', strtotime($dateStop));
        } else {
            if(!$date) {
                $date = date('Y-m-d');
            }

            $dateStart = date('Y-m-d', strtotime($date)-($this->module->salaryPeriodDays*86400));
            $dateStop = date('Y-m-d');
        }
        
        $sessions = yii::$app->worksess->getSessionsByDatePeriod($dateStart, $dateStop);
        $staffers = Staffer::find()->where(['status' => 'active'])->all();
        
        return $this->render('index', [
            'dateStart' => $dateStart,
            'dateStop' => $dateStop,
            'staffers' => $staffers,
            'sessions' => $sessions,
            'module' => $this->module,
        ]);
    }
    
    public function actionUpdate($sessionId, $stafferId)
    {
        $model = Salary::find()->where(['session_id' => $sessionId, 'worker_id' => $stafferId])->one();

        if(!$model) {
            throw new NotFoundHttpException('The requested salary does not exist.');
        }
        
        $module = $this->module;

        if ($model->load(Yii::$app->request->post())) {
            $model->salary = $model->charged+$model->fix+$model->bonuses-$model->fines;
            $model->save(false);
            
            return $this->redirect(yii::$app->request->referrer);
        } else {
            return $this->render('update', ['model' => $model, 'module' => $this->module]);
        }
    }
}
