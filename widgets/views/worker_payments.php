<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
?>
<div class="worker-payments-widget">
    <div class="summary">
        Всего:
        <?=number_format($dataProvider->query->sum('sum'), 2, ',', '.');?>
    </div>
    <?php Pjax::begin(); ?>
    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['attribute' => 'id', 'filter' => false, 'options' => ['style' => 'width: 49px;']],
            ['attribute' => 'sum', 'filter' => false, 'label' => 'Выплачено'],
            [
                'label' => 'Долг',
                'content' => function($model) {

                    $sessionStatistic = \Yii::$app->service->getReportBySession($model->session);
                    return $sessionStatistic['salary'][$model->worker_id]['salary'] - $model->sum;
                }
            ],
            'date',
            [
                'attribute' => 'session_id',
                'filter' => false,
                'content' => function($model) {
                    return "<a href=". Url::to(['/service/report/index', 'sessionId' => $model->session_id]) .">". date('d.m.Y', $model->session->start_timestamp). "</a>";
                }
            ],
            [
                'label' => 'Заработано за сессию',
                'content' => function($model) {

                    $sessionStatistic = \Yii::$app->service->getReportBySession($model->session);
                    return$sessionStatistic['salary'][$model->worker_id]['salary'];
                }
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
