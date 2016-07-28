<?php
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use pistol88\staffer\models\Category;
use pistol88\worksess\widgets\ControlButton;
use pistol88\worksess\widgets\Info;

$this->title = 'Сотрудники';
$this->params['breadcrumbs'][] = $this->title;

\pistol88\staffer\assets\BackendAsset::register($this);
?>
<div class="model-index">

    <div class="row">
        <div class="col-md-2">
            <?= Html::a('Добавить сотрудника', ['create'], ['class' => 'btn btn-success']) ?>
        </div>
        <div class="col-md-10">
            <?=$this->render('../parts/menu');?>
        </div>
    </div>
    
    <?php
    echo \kartik\grid\GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'export' => false,
        'columns' => [
            [
                'attribute' => 'image',
                'filter' => false,
                'content' => function ($image) {
                    if($image->image && $image = $image->image->getUrl('100x100')) {
                        return "<img src=\"{$image}\" class=\"thumb\" />";
                    }
                }
            ],
            ['attribute' => 'id', 'filter' => false, 'options' => ['style' => 'width: 55px;']],
            'name',
            [
                'attribute' => 'status',
                'filter' => Html::activeDropDownList(
                    $searchModel,
                    'status',
                    $module->stafferStatuses,
                    ['class' => 'form-control', 'prompt' => 'Статус']
                ),
                'content' => function($model) use ($module) {
                    return @$module->stafferStatuses[$model->status];
                }
            ],
            [
                'attribute' => 'session',
                'content' => function($model) use ($module) {
                    if(in_array($model->status, $module->activeStatuses)) {
                        return Info::widget(['for' => $model]).ControlButton::widget(['for' => $model]);
                    }
                }
            ],
            [
                'attribute' => 'category_id',
                'filter' => Html::activeDropDownList(
                    $searchModel,
                    'category_id',
                    Category::buildTextTree(),
                    ['class' => 'form-control', 'prompt' => 'Категория']
                ),
                'value' => 'category.name'
            ],

            ['class' => 'yii\grid\ActionColumn', 'template' => '{update} {delete}',  'buttonOptions' => ['class' => 'btn btn-default'], 'options' => ['style' => 'width: 125px;']],
        ],
    ]); ?>

</div>
