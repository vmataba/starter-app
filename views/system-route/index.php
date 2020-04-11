<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\assets\DataDefinition;
use app\assets\tools\Tool;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SystemRouteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'System Routes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="system-route-index">


    <p>
        <?= Html::a('Add New Route', ['create'], ['class' => 'btn btn-success btn-sm']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'id',
            [
                'attribute' => 'module',
                'value' => function ($model) {
                    return empty($model->module) ? Tool::getNoContentMessage() : $model->module;
                },
                'format' => 'raw',
                'filterInputOptions' => [
                    'placeholder' => 'Search...',
                    'class' => 'form-control'
                ]
            ],
            [
                'attribute' => 'controller',
                'filterInputOptions' => [
                    'placeholder' => 'Search...',
                    'class' => 'form-control'
                ]
            ],
            [
                'attribute' => 'action',
                'filterInputOptions' => [
                    'placeholder' => 'Search...',
                    'class' => 'form-control'
                ]
            ],
            [
                'attribute' => 'pretty_name',
                'filterInputOptions' => [
                    'placeholder' => 'Search...',
                    'class' => 'form-control'
                ],
                'value' => function ($model) {
                    return $model->countUses() != 1 ? $model->pretty_name . "<span class='text-muted' style='font-weight:bold'> (" . $model->countUses() . " Uses)</span>" : $model->pretty_name . "<span class='text-muted' style='font-weight:bold'> (" . $model->countUses() . " Use)</span>";
                },
                'format' => 'raw'
            ],
            [
                'attribute' => 'is_active',
                'value' => function ($model) {
                    return DataDefinition::getStyledBooleanTypes()[$model->is_active];
                },
                'format' => 'raw',
                'filter' => DataDefinition::getBooleanTypes(),
                'filterInputOptions' => [
                    'prompt' => 'Select...',
                    'class' => 'form-control'
                ]
            ],
            //'created_at',
            //'created_by',
            //'updated_at',
            //'updated_by',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => "{view}{update}"
            ],
        ],
    ]);
    ?>


</div>
