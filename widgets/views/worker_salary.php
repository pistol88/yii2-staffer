<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use nex\datepicker\DatePicker;
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

if($dateStart = yii::$app->request->get('date_start')) {
    $dateStart = date('d.m.Y', strtotime($dateStart));
}

if($dateStop = yii::$app->request->get('date_stop')) {
    $dateStop = date('d.m.Y', strtotime($dateStop));
}

?>
<div class="worker-payments-widget">

    <?php Pjax::begin(); ?>

    <div class="filter">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Фильтр</h3>
            </div>
            <div class="panel-body">
                <form action="" class="row search" data-pjax="true">
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-6">
                                <?= DatePicker::widget([
                                    'name' => 'date_start',
                                    'addon' => false,
                                    'value' => $dateStart,
                                    'size' => 'sm',
                                    'language' => 'ru',
                                    'placeholder' => yii::t('order', 'Date from'),
                                    'clientOptions' => [
                                        'format' => 'L',
                                        'minDate' => '2015-01-01',
                                        'maxDate' => date('Y-m-d'),
                                    ],
                                    'dropdownItems' => [
                                        ['label' => 'Yesterday', 'url' => '#', 'value' => \Yii::$app->formatter->asDate('-1 day')],
                                        ['label' => 'Tomorrow', 'url' => '#', 'value' => \Yii::$app->formatter->asDate('+1 day')],
                                        ['label' => 'Some value', 'url' => '#', 'value' => 'Special value'],
                                    ],
                                ]);?>
                            </div>
                            <div class="col-md-6">
                                <?= DatePicker::widget([
                                    'name' => 'date_stop',
                                    'addon' => false,
                                    'value' => $dateStop,
                                    'size' => 'sm',
                                    'placeholder' => yii::t('order', 'Date to'),
                                    'language' => 'ru',
                                    'clientOptions' => [
                                        'format' => 'L',
                                        'minDate' => '2015-01-01',
                                        'maxDate' => date('Y-m-d'),
                                    ],
                                    'dropdownItems' => [
                                        ['label' => yii::t('order', 'Yesterday'), 'url' => '#', 'value' => \Yii::$app->formatter->asDate('-1 day')],
                                        ['label' => yii::t('order', 'Tomorrow'), 'url' => '#', 'value' => \Yii::$app->formatter->asDate('+1 day')],
                                        ['label' => yii::t('order', 'Some value'), 'url' => '#', 'value' => 'Special value'],
                                    ],
                                ]);?>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <input class="form-control btn-success" type="submit" value="<?=Yii::t('order', 'Search');?>" />
                    </div>
                    <div class="col-md-3">
                        <a class="btn btn-default" href="<?= Url::to(['/staffer/staffer/view', 'id' => $worker->id]) ?>" />Cбросить все фильтры</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="summary">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Итого</h3>
            </div>
            <div class="panel-body">
                <?php if (count($models) > 0) {
                    if(!($fix = $worker->fix)) {
                        $fix = 0;
                    }

                    //$totalTimeElapsed = 0; // всего отработано за период

                    // заработано
                    $totalBaseSalary = 0; // всего грязными за период
                    $totalFix = 0; // всего по фиксу за период
                    $totalFines = 0; // всего по штрафам за период
                    $totalBonuses = 0; // всего по бонусам за период
                    $totalSalary = 0; // всего чистыми за период

                    // выплачено
                    $totalPayed = 0;

                    foreach ($models as $key => $model) {

                        $payments = \Yii::$app->staffer->getStafferPaymentsBySession($model->worker_id, $model->session_id);

                        //  время на смене
                        // if (!is_null($model->stop_timestamp)) {
                        //     $totalTimeElapsed += $model->stop_timestamp - $model->start_timestamp;
                        // } else {
                        //     $totalTimeElapsed += time() - $model->start_timestamp;
                        // }

                        //  заработано
                        $totalBaseSalary += $model->charged;
                        $totalFix += $fix;
                        $totalFines += $model->fines;
                        $totalBonuses += $model->bonuses;

                        $totalSalary += $model->salary;

                        // выплачено
                        if ($payed = $payments->sum('sum')) {
                            $totalPayed += $payed;
                        }
                    }

                    // $day = ( $totalTimeElapsed / 86400 ) % 30;
                    // $hour = ( $totalTimeElapsed / 3600 ) % 3600;
                    // $min = ( $totalTimeElapsed / 60 ) % 60;

                    // $totalTimeElapsedString = '';
                    // $totalTimeElapsedString .= $day > 0 ? 'Дней: '. $day . ' ' : '' ;
                    // $totalTimeElapsedString .= $hour > 0 ? 'Часов: '. $hour . ' ' : '' ;
                    // $totalTimeElapsedString .= $min > 0 ? 'Минут: '. $min . ' ' : 'Минут: 0' ;
                    ?>

                    <p>
                        <!-- Отработано за период: <?php // echo $totalTimeElapsedString ?>. -->
                        Всего смен за период: <?= count($models) ?>
                    </p>
                    <p>
                        Заработано:
                    </p>
                        <table class="table table-bordered">
                            <tr>
                                <td>
                                    Начислено
                                </td>
                                <td>
                                    <?= number_format($totalBaseSalary, 2, ',', ' ') ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Фикс
                                </td>
                                <td>
                                    <?= number_format($totalFix, 2, ',', ' ') ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Штрафы
                                </td>
                                <td>
                                    <?= number_format($totalFines, 2, ',', ' ') ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Бонусы
                                </td>
                                <td>
                                    <?= number_format($totalBonuses, 2, ',', ' ') ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    К выплате
                                </td>
                                <td>
                                    <?= number_format($totalSalary, 2, ',', ' ') ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Осталось выплатить
                                </td>
                                <td>
                                    <?= number_format(($totalSalary - $totalPayed), 2, ',', ' ') ?>
                                </td>
                            </tr>
                        </table>
                        <p>
                            Выплачено за период: <?= number_format($totalPayed, 2, ',', ' ') ?>
                        </p>
                 <?php } ?>
            </div>
        </div>

    </div>

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
                    $payments = \Yii::$app->staffer->getStafferPaymentsBySession($model->worker_id, $model->session->id);
                ?>
                <tr>
                    <td>
                        <a href="<?=Url::to(['/service/report/index', 'sessionId' => $model->session->id])?>"><?=date('d.m.Y', $model->session->start_timestamp)?></a>;
                    </td>
                    <td>
                        <!-- время на смене -->

                        <?php
                        if (!is_null($model->session->stop_timestamp)) {
                            $timeElapsed = $model->session->stop_timestamp - $model->session->start_timestamp;
                        } else {
                            $timeElapsed = time() - $model->session->start_timestamp;
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
                        <?php $tooltip = '<p>Грязные: '.$model->charged.'</p>'
                             . '<p>Фикс: '.$fix.'</p>'
                             . '<p>Штрафы: '.$model->fines.'</p>'
                             . '<p>Бонусы: '.$model->fines.'</p>';

                            echo Html::tag('a', number_format($model->salary, 2, ',', ' '), [
                                'data-template' => '<div class="popover" role="tooltip"><div class="popover-arrow"></div><div class="popover-content"></div></div>',
                                'data-title' => 'Заработано',
                                'data-html' => 'true',
                                'data-content' => $tooltip,
                                'data-toggle' => 'popover',
                                'data-placement' => 'top',
                                'tabindex' => '0',
                                'data-trigger' => 'focus',
                                'style' => 'cursor:pointer;'
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
                        <?php  echo $model->salary - $payed; ?>
                        <?php // echo $sessionStatistic['salary'][$model->user_id]['salary'] - $payed; ?>
                    </td>
                    <td>
                        <!-- кнопка выплатить -->
                        <?php
                            if ($model->salary - $payed > 0) {
                                echo \pistol88\staffer\widgets\AddPayment::widget([
                                    'staffer' => Staffer::findOne($model->worker_id),
                                    'paymentSum' => ($model->salary - $payed),
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

    <?= \yii\widgets\LinkPager::widget([
        'pagination'=>$dataProvider->pagination,
    ]); ?>

    <?php Pjax::end(); ?>
</div>
