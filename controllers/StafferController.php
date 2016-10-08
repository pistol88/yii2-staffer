<?php
namespace pistol88\staffer\controllers;

use yii;
use pistol88\staffer\models\staffer\StafferSearch;
use pistol88\staffer\models\Staffer;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class StafferController extends Controller
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
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'edittable' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new StafferSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'module' => $this->module,
        ]);
    }

    public function actionCreate()
    {
        $model = new Staffer;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $module = $this->module;

            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'module' => $this->module,
            ]);
        }
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $module = $this->module;

            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('update', ['model' => $model, 'module' => $this->module]);
        }
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);

        return $this->render('view', ['model' => $model, 'module' => $this->module]);
    }
    
    public function actionDelete($id)
    {
        if($model = $this->findModel($id)) {
            $this->findModel($id)->delete();
            $module = $this->module;
        }
		
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        $model = new Staffer;
        
        if (($model = $model::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested staffer does not exist.');
        }
    }
}
