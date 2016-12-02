<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
?>
<div class="worker-debts-widget">
    <div class="summary">
        Общая сумма аванса: <?= $totalDebt ?>
    </div>
    <?php Pjax::begin(); ?>
    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            // ['attribute' => 'id', 'filter' => false, 'options' => ['style' => 'width: 49px;']],
            [
                'attribute' => 'date',
                'value' => function($model) {
                    return  date('d.m.Y H:i:s', strtotime($model->date));
                }
            ],
            ['attribute' => 'sum', 'filter' => false, 'label' => 'Выплачено'],
            [
                'attribute' => 'session_id',
                'filter' => false,
                'content' => function($model) {
                    return 'сессия '.$model->session_id;
                    // return "<a href=". Url::to(['/service/report/index', 'sessionId' => $model->session_id]) .">". date('d.m.Y', $model->session->start_timestamp). "</a>";
                }
            ],
            // 'debt',
            [
                'attribute' => 'type',
                'filter' => 'false',
                'content' => function($model) {
                    $translateArray = ['given' => 'Выдача', 'return' => 'Возврат'];
                    return $translateArray[$model->type];
                }
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
