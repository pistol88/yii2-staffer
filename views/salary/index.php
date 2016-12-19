<?php
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use pistol88\staffer\models\Category;

$this->title = 'Зарплатная ведомость';
$this->params['breadcrumbs'][] = $this->title;

\pistol88\staffer\assets\BackendAsset::register($this);

$sessionsSum = [];

?>
<div class="model-index container-full">

    <div class="row">
        <div class="col-md-2">
            
        </div>
        <div class="col-md-10">
            <?=$this->render('../parts/menu');?>
        </div>
    </div>
    
    <h1>Зарплатная ведомость</h1>
    <p><?=$dateStart;?> - <?=$dateStop;?></p>
    <a href="#" class="btn btn-submit" onclick="pistol88.staffer.callPrint('worker-sapary-container'); return false;" style="float: right;"><i class="glyphicon glyphicon-print"></i></a>
    
    <div id="worker-sapary-container">
    <table class="table workers-salary" id="workers-salary">
        <tr>
            <th>
                Сотрудник
            </th>

            <?php foreach($sessions as $session) { ?>
                <th><a href="<?=Url::toRoute([$module->sessionReportUrl, 'sessionId' => $session->id]);?>" title="<?=date('d.m.Y', $session->start_timestamp);?> <?=$session->shift;?>"><?=date('d', $session->start_timestamp);?></a></th>
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
                <?php } ?>
                <th>
                    <p>
                        <?=$totalSum;?>
                    </p>
                </th>
                <td>
                    <a href="<?=Url::toRoute(['/staffer/staffer/view', 'id' => $staffer->id, 'date_start' => $dateStart, 'date_stop' => $dateStop, 'checkall' => 1]);?>#salaryTable" class="btn btn-success" title="Выплатить">
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
            <th>~</th>
            <?php foreach($sessions as $session) { ?>
                <td><?=$sessionsSum[$session->id];?></td>
            <?php } ?>
            <th><?=array_sum($sessionsSum);?></th>
            <td>~</td>
        </tr>
        
    </table>
    </div>
</div>
