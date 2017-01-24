<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

$this->title = Html::encode($model->name);
$this->params['breadcrumbs'][] = ['label' => 'Сотрудники', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Просмотр';


?>
<div class="staffer-view">

    <h1><?= $model->name ?></h1>

    <p><a href="<?=Url::toRoute(['update', 'id' => $model->id]);?>" class="btn btn-success">Редактировать</a></p>

    <?=DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'category.name',
            'status',
            'pay_type',
            'text',
            'persent',
			'fix',
        ],
    ]);?>

    <ul class="nav nav-tabs">
        <?php if(class_exists('\pistol88\staffer\widgets\WorkerSalary')) { ?><li class="active"><a data-toggle="tab" href="#staffer-salary">Зарплаты</a></li><?php } ?>
        <li ><a data-toggle="tab" href="#staffer-more">Дополнительно</a></li>
        <?php if(class_exists('\pistol88\staffer\widgets\AddFine')) { ?><li><a data-toggle="tab" href="#staffer-fines">Штрафы</a></li><?php } ?>
        <?php /* if(class_exists('\pistol88\staffer\widgets\WorkerPayments')) { ?><li><a data-toggle="tab" href="#staffer-payments">Выплаты</a></li><?php  }*/ ?>
        <?php if(class_exists('\pistol88\staffer\widgets\WorkerDebt')) { ?><li><a data-toggle="tab" href="#staffer-debts">Долги</a></li><?php } ?>
        <?php if(class_exists('\pistol88\staffer\widgets\WorkerBonus')) { ?><li><a data-toggle="tab" href="#staffer-bonus">Премии</a></li><?php } ?>
    </ul>

    <div class="tab-content" style="padding: 10px;">
        <div id="staffer-more" class="tab-pane fade">
            <?php if($fieldPanel = \pistol88\field\widgets\Show::widget(['model' => $model])) { ?>
                <?=$fieldPanel;?>
            <?php } else { ?>
                <p>Доп. поля не добавлены.</p>
            <?php } ?>
        </div>
        <?php if(class_exists('\pistol88\staffer\widgets\AddFine')) { ?>
            <div id="staffer-fines" class="tab-pane fade">
                <?=\pistol88\staffer\widgets\AddFine::widget(['staffer' => $model]);?>
            </div>
        <?php } ?>
        <?php /* if(class_exists('\pistol88\service\widgets\WorkerPayments')) { ?>
            <div id="staffer-payments" class="tab-pane fade">
                <?=\pistol88\staffer\widgets\WorkerPayments::widget(['worker_id' => $model->id]);?>
            </div>
        <?php } */ ?>
        <?php if(class_exists('\pistol88\staffer\widgets\WorkerSalary')) { ?>
            <div id="staffer-salary" class="tab-pane fade in active">
                <?=\pistol88\staffer\widgets\WorkerSalary::widget(['worker' => $model]);?>
            </div>
        <?php } ?>
        <?php if(class_exists('\pistol88\staffer\widgets\WorkerDebt')) { ?>
            <div id="staffer-debts" class="tab-pane fade">
                <div class="row">
                    <div class="col-sm-12">
                        <?=\pistol88\staffer\widgets\AddDebt::widget(['worker' => $model]);?>
                        <?=\pistol88\staffer\widgets\ReturnDebt::widget(['worker' => $model]);?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <?=\pistol88\staffer\widgets\WorkerDebt::widget(['worker' => $model]);?>
                    </div>
                </div>
            </div>
        <?php } ?>
        <?php if(class_exists('\pistol88\staffer\widgets\WorkerBonus')) { ?>
            <div id="staffer-bonus" class="tab-pane fade">
                <div class="row">
                    <div class="col-sm-3">
                        <?=\pistol88\staffer\widgets\AddBonus::widget(['staffer' => $model]);?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <?=\pistol88\staffer\widgets\WorkerBonus::widget(['staffer' => $model]);?>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    <div class="row text-right">
        <div class="col-sm-12">
            <a href="<?= Url::to(['/staffer/salary/index']); ?>">Перейти на зарплатную ведомость</a>   
        </div>
    </div>
</div>
