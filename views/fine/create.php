<?php
use yii\helpers\Html;

$this->title = 'Добавить штраф';
$this->params['breadcrumbs'][] = ['label' => 'Штрафы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fine-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'module' => $module,
    ]) ?>

</div>
