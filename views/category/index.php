<?php
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use pistol88\staffer\models\Category;

$this->title = 'Категории';
$this->params['breadcrumbs'][] = $this->title;

\pistol88\staffer\assets\BackendAsset::register($this);
?>
<div class="category-index">
    
    <div class="row">
        <div class="col-md-2">
            <?= Html::a('Создать категорию', ['create'], ['class' => 'btn btn-success']) ?>
        </div>
        <div class="col-md-10">
            <?=$this->render('../parts/menu');?>
        </div>
    </div>

    <br style="clear: both;"></div>

    <?=\kartik\grid\GridView::widget([
            'export' => false,
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                ['attribute' => 'id', 'filter' => false, 'options' => ['style' => 'width: 55px;']],
                'name',
                [
                    'attribute' => 'image',
                    'format' => 'image',
                    'filter' => false,
                    'content' => function ($image) {
                        if($image = $image->getImage()->getUrl('50x50')) {
                            return "<img src=\"{$image}\" class=\"thumb\" />";
                        }
                    }
                ],
                [
                    'attribute' => 'parent_id',
                    'filter' => Html::activeDropDownList(
                        $searchModel,
                        'parent_id',
                        Category::buildTextTree(),
                        ['class' => 'form-control', 'prompt' => 'Категория']
                    ),
                    'value' => 'parent.name'
                ],
                ['class' => 'yii\grid\ActionColumn', 'template' => '{update} {delete}',  'buttonOptions' => ['class' => 'btn btn-default'], 'options' => ['style' => 'width: 125px;']],
            ],
        ]); ?>

</div>
