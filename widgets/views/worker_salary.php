<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use pistol88\staffer\models\Staffer;

$models = $dataProvider->getModels();

$js = <<< 'SCRIPT'
$(function () {
    $("[data-toggle='tooltip']").tooltip();
});;
$(function () {
    $("[data-toggle='popover']").popover();
});
SCRIPT;
$this->registerJs($js);

?>
<div class="worker-payments-widget">
    <div class="summary">
        Всего:

    </div>
    <?php Pjax::begin(); ?>

    <table class="table table-bordered">
        <tr>
            <th>
                Дата смены
            </th>
            <th>
                Время на смене
            </th>
            <th>
                Заработано
            </th>
            <th>
                Выплачено
            </th>
            <th>
                К выплате
            </th>
            <th>

            </th>
        </tr>

        <?php if (count($models) > 0) { ?>
            <?php foreach ($models as $key => $model) { ?>
                <?php
                    $sessionStatistic = \Yii::$app->service->getReportBySession($model->session);
                    $payments = \Yii::$app->staffer->getStafferPaymentsBySession($model->user_id, $model->session->id);
                ?>
                <tr>
                    <td>
                        <a href="<?=Url::to(['/service/report/index', 'sessionId' => $model->session_id])?>"><?=date('d.m.Y', $model->start_timestamp)?></a>;
                    </td>
                    <td>
                        <!-- время на смене -->

                        <?php
                        if (!is_null($model->stop_timestamp)) {
                            $timeElapsed = $model->stop_timestamp - $model->start_timestamp;
                        } else {
                            $timeElapsed = time() - $model->start_timestamp;
                        }

                        $day = ( $timeElapsed / 86400 ) % 30;
                        $hour = ( $timeElapsed / 3600 ) % 24;
                        $min = ( $timeElapsed / 60 ) % 60;

                        $return = '';
                        $return .= $day > 0 ? 'Дней: '. $day . ' ' : '' ;
                        $return .= $hour > 0 ? 'Часов: '. $hour . ' ' : '' ;
                        $return .= $min > 0 ? 'Минут: '. $min . ' ' : 'Минут: 0' ;

                        echo  $return;
                        ?>
                    </td>
                    <td>
                        <!-- заработано -->
                        <?php $tooltip = '<p>Грязные: '.$sessionStatistic['salary'][$model->user_id]['base_salary'].'</p>'
                             . '<p>Фикс: '.$sessionStatistic['salary'][$model->user_id]->fix.'</p>'
                             . '<p>Штрафы: '.$sessionStatistic['salary'][$model->user_id]['fines'].'</p>'
                             . '<p>Бонусы: '.$sessionStatistic['salary'][$model->user_id]['bonuses'].'</p>';

                            echo Html::tag('a', number_format(round(($sessionStatistic['salary'][$model->user_id]['salary']), 0, PHP_ROUND_HALF_DOWN), 2, ',', '.'), [
                                'data-template' => '<div class="popover" role="tooltip"><div class="popover-arrow"></div><div class="popover-content"></div></div>',
                                'data-title' => 'Заработано',
                                'data-html' => 'true',
                                'data-content' => $tooltip,
                                'data-toggle' => 'popover',
                                'data-placement' => 'top',
                                'tabindex' => '0',
                                'data-trigger' => 'focus',
                                'style' => 'text-decoration: underline; cursor:pointer;'
                            ]);
                        ?>
                    </td>
                    <td>
                        <!-- выплачено -->
                        <?php
                            if ($payed = $payments->sum('sum')) {
                                echo $payed;
                            } else {
                                echo 'выплат не было';
                            }
                        ?>
                    </td>
                    <td>
                        <!-- к выплате -->
                        <?= round($sessionStatistic['salary'][$model->user_id]['salary'], 0, PHP_ROUND_HALF_DOWN) - $payed; ?>
                    </td>
                    <td>
                        <!-- кнопка выплатить -->
                        <?php
                            if ($sessionStatistic['salary'][$model->user_id]['salary'] - $payed > 0) {
                                echo \pistol88\staffer\widgets\AddPayment::widget([
                                    'staffer' => Staffer::findOne($model->user_id),
                                    'paymentSum' => round(($sessionStatistic['salary'][$model->user_id]['salary'] - $payed), 0, PHP_ROUND_HALF_DOWN),
                                    'sessionId' => $model->session->id
                                ]);
                            }
                        ?>
                    </td>
                </tr>
            <?php } ?>
         <?php } ?>
        <tr>

        </tr>
    </table>

    <?php /*
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            ['attribute' => 'id', 'filter' => false, 'options' => ['style' => 'width: 49px;']],
            [
                'label' => 'Дата смены',
                'format' => 'raw',
                'value' => function($model) {
                    return "<a href=". Url::to(['/service/report/index', 'sessionId' => $model->session_id]) .">". date('d.m.Y', $model->start_timestamp). "</a>";
                },
                'options' => ['style' => 'width: 120px;']
            ],
            [
                'label' => 'Время на смене',
                'value' => function($model) {
                    if (!is_null($model->stop_timestamp)) {
                        $timeElapsed = $model->stop_timestamp - $model->start_timestamp;
                    } else {
                        $timeElapsed = time() - $model->start_timestamp;
                    }

                    $day = ( $timeElapsed / 86400 ) % 30;
                    $hour = ( $timeElapsed / 3600 ) % 24;
                    $min = ( $timeElapsed / 60 ) % 60;

                    $return = '';
                    $return .= $day > 0 ? 'Дней: '. $day . ' ' : '' ;
                    $return .= $hour > 0 ? 'Часов: '. $hour . ' ' : '' ;
                    $return .= $min > 0 ? 'Минут: '. $min . ' ' : 'Минут: 0' ;
                    return $return;

                }
            ],
            [
                'label' => 'Заработано',
                'format' => 'raw',
                'value' => function($model) {
                    $sessionStatistic = \Yii::$app->service->getReportBySession($model->session);

                    $tooltip = '<p>Грязные: '.$sessionStatistic['salary'][$model->user_id]['base_salary'].'</p>'
                     . '<p>Фикс: '.$sessionStatistic['salary'][$model->user_id]->fix.'</p>'
                     . '<p>Штрафы: '.$sessionStatistic['salary'][$model->user_id]['fines'].'</p>'
                     . '<p>Бонусы: '.$sessionStatistic['salary'][$model->user_id]['bonuses'].'</p>';

                    return Html::tag('a', $sessionStatistic['salary'][$model->user_id]['salary'], [
                        'data-template' => '<div class="popover" role="tooltip"><div class="popover-arrow"></div><div class="popover-content"></div></div>',
                        'data-title' => 'Заработано',
                        'data-html' => 'true',
                        'data-content' => $tooltip,
                        'data-toggle' => 'popover',
                        'data-placement' => 'top',
                        'tabindex' => '0',
                        'data-trigger' => 'focus',
                        'style' => 'text-decoration: underline; cursor:pointer;'
                    ]);
                }
            ],
            [
                'label' => 'Выплачено',
                'value' => function($model) {
                    $payments = \Yii::$app->staffer->getStafferPaymentsBySession($model->user_id, $model->session->id);
                    if ($payed = $payments->sum('sum')) {
                        return $payed;
                    } else {
                        return 'выплат не было';
                    }
                }
            ],
            [
                'label' => 'К выплате',
                'format' => 'raw',
                'value' => function($model) {
                    // $sessionStatistic = \Yii::$app->service->getReportBySession($model->session);
                    //
                    // $payments = \Yii::$app->staffer->getStafferPaymentsBySession($model->user_id, $model->session->id);
                    // $payed = $payments->sum('sum');
                    //
                    // return $sessionStatistic['salary'][$model->user_id]['salary'] - $payed;

                }
            ],
            [
                'format' => 'raw',
                'value' => function($model) {
                    $sessionStatistic = \Yii::$app->service->getReportBySession($model->session);

                    $payments = \Yii::$app->staffer->getStafferPaymentsBySession($model->user_id, $model->session->id);
                    $payed = $payments->sum('sum');

                    if($sessionStatistic['salary'][$model->user_id]['salary'] > 0) {
                        return \pistol88\staffer\widgets\AddPayment::widget([
                            'staffer' => Staffer::findOne($model->user_id),
                            'paymentSum' => round(($sessionStatistic['salary'][$model->user_id]['salary'] - $payed), 0, PHP_ROUND_HALF_DOWN),
                            'sessionId' => $model->session->id
                        ]);
                    }
                }
            ]
            // [
            //     'label' => 'Долг',
            //     'content' => function($model) {
            //
            //         $sessionStatistic = \Yii::$app->service->getReportBySession($model->session);
            //         return $sessionStatistic['salary'][$model->worker_id]['salary'] - $model->sum;
            //     }
            // ],
            // 'date',
            // [
            //     'attribute' => 'session_id',
            //     'filter' => false,
            //     'content' => function($model) {
            //         return "<a href=". Url::to(['/service/report/index', 'sessionId' => $model->session_id]) .">". date('d.m.Y', $model->session->start_timestamp). "</a>";
            //     }
            // ],
            // [
            //     'label' => 'Заработано за сессию',
            //     'content' => function($model) {
            //
            //         $sessionStatistic = \Yii::$app->service->getReportBySession($model->session);
            //         return$sessionStatistic['salary'][$model->worker_id]['salary'];
            //     }
            // ],
        ],
    ]); */ ?>

    <?php Pjax::end(); ?>
</div>
