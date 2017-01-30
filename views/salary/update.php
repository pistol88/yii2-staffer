<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model pistol88\staffer\models\Category */

$this->title = 'Перерасчет зарплаты' . ' за ' . date('d.m.Y', $model->date_timestamp);
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="salary-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    
</div>
