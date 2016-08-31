<?php
namespace pistol88\staffer\controllers;

use yii;
use pistol88\staffer\models\fine\FineSearch;
use pistol88\staffer\models\Fine;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class FineController extends Controller
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
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new FineSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $model = new Fine;
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
            'module' => $this->module,
        ]);
    }

    public function actionCreate()
    {
        $model = new Fine;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $module = $this->module;

            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
                'module' => $this->module,
            ]);
        }
    }

    public function actionAjaxCreate()
    {
        $model = new Fine();

        $json = [];
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $json['result'] = 'success';
            $json['id'] = $model->id;
        } else {
            $json['result'] = 'fail';
            $json['errors'] = current($model->getFirstErrors());
        }
        
        return json_encode($json);
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
        $model = new Fine;
        
        if (($model = $model::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested fine does not exist.');
        }
    }
}
