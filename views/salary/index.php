<?php
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use pistol88\staffer\models\Category;
use nex\datepicker\DatePicker;

$this->title = 'Зарплатная ведомость';
$this->params['breadcrumbs'][] = $this->title;

\pistol88\staffer\assets\BackendAsset::register($this);

$sessionsSum = [];
$lastSessionStop = [];

?>
<div class="model-index container-full">

    <div class="row">
        <div class="col-md-2">
            
        </div>
        <div class="col-md-10">
            <?=$this->render('../parts/menu');?>
        </div>
    </div>
    
    
    
    
    <form action="" method="get">
        <p>Выберите период:</p>
        <div class="row">
            <div class="col-md-4">
                <?= DatePicker::widget([
                    'name' => 'date',
                    'addon' => false,
                    'value' => $dateStart,
                    'size' => 'sm',
                    'language' => 'ru',
                    'options' => [
                        'onchange' => '',
                    ],
                    'placeholder' => 'На дату...',
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
            <div class="col-md-4">
                <?= DatePicker::widget([
                    'name' => 'dateStop',
                    'addon' => false,
                    'value' => $dateStop,
                    'size' => 'sm',
                    'language' => 'ru',
                    'options' => [
                        'onchange' => '',
                    ],
                    'placeholder' => 'На дату...',
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
            <div class="col-md-4">
                <input type="submit" value="Применить" class="btn btn=submit" />
            </div>
        </div>
    </form>
    
    <div id="worker-sapary-container">
        
        <h1>Зарплатная ведомость</h1>
        <p><?=date('d.m.Y', strtotime($dateStart)); ?> - <strong><?=date('d.m.Y', strtotime($dateStop)); ?></strong></p>
        <a href="#" class="btn btn-submit" onclick="pistol88.staffer.callPrint('worker-sapary-container'); return false;" style="float: right;"><i class="glyphicon glyphicon-print"></i></a>
        
        <div style="width: 100%; overflow-x: scroll;">
            <table class="table table-bordered table-striped workers-salary" id="workers-salary">
                <tr>
                    <th>
                        Сотрудник
                    </th>

                    <?php foreach($sessions as $session) { ?>
                        <th><a href="<?=Url::toRoute([$module->sessionReportUrl, 'sessionId' => $session->id]);?>" title="<?=date('d.m.Y', $session->start_timestamp);?> <?=$session->shift;?> - <?=date('d.m.Y H:i:s', $session->stop_timestamp);?>"><?=date('d', $session->start_timestamp);?></a></th>
                    <?php } ?>
                    
                    <th>
                        Итого
                    </th>
                    <th>
                        
                    </th>
                </tr>
                
                <?php foreach($staffers as $staffer) { ?>
                    <?php $totalSum = 0; ?>
                    <tr class="staffer_salary_<?=$staffer->id;?>">
                        <td>
                            <strong><a href="<?=Url::toRoute(['/staffer/staffer/view', 'id' => $staffer->id, 'date_start' => $dateStart, 'date_stop' => $dateStop]);?>"><?=$staffer->name;?></a></strong>
                        </td>
                        <?php foreach($sessions as $session) { ?>
                            <?php if($sum = $staffer->getSalaryBySessionId($session->id)) { ?>
                                <?php
                                $totalSum += $sum;
                                $sessionsSum[$session->id] += $sum;
                                ?>
                                <td><?=$sum;?></td>
                            <?php } else { ?>
                                <td>-</td>
                            <?php } ?>
                        <?php if($session->stop_timestamp) $lastSessionStop[$staffer->id] = date('d.m.Y', $session->stop_timestamp); } ?>
                        <th>
                            <p>
                                <?=$totalSum;?>
                            </p>
                        </th>
                        <td>
                            <a href="<?=Url::toRoute(['/staffer/staffer/view', 'id' => $staffer->id, 'date_start' => $dateStart, 'date_stop' => $lastSessionStop[$staffer->id], 'checkall' => 1]);?>#salaryTable" class="btn btn-success" title="Выплатить">
                                <i class="glyphicon glyphicon-check"></i>
                            </a>
                        </td>
                    </tr>
                    <?php if(!$totalSum) { ?>
                    <style>
                    .staffer_salary_<?=$staffer->id;?> {
                        display: none;
                    }
                    </style>
                    <?php } ?>

                <?php } ?>
                
                <tr>
                    <th>Итого</th>
                    <?php foreach($sessions as $session) { ?>
                        <td><?=$sessionsSum[$session->id];?></td>
                    <?php } ?>
                    <th><?=array_sum($sessionsSum);?></th>
                    <td></td>
                </tr>
                
            </table>
        </div>
    </div>
</div>
