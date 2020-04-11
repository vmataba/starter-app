<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\assets\DataDefinition;
use app\assets\tools\Tool;

/* @var $this yii\web\View */
/* @var $searchModel app\models\InstitutionTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Institution Types';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="institution-type-index">
    <p>
        <?= Html::a('Add New Type', ['create'], ['class' => 'btn btn-success btn-sm']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'id',
            [
                'attribute' => 'institution_type_name',
                'filterInputOptions' => [
                    'placeholder' => 'Search...',
                    'class' => 'form-control'
                ]
            ],
            [
                'attribute' => 'rank',
                'filterInputOptions' => [
                    'placeholder' => 'Search...',
                    'class' => 'form-control'
                ]
            ],
            [
                'attribute' => 'is_active',
                'value' => function ($model) {
                    return DataDefinition::getStyledBooleanTypes()[$model->is_active];
                },
                'format' => 'html',
                'filter' => DataDefinition::getBooleanTypes(),
                'filterInputOptions' => [
                    'prompt' => 'Select...',
                    'class' => 'form-control'
                ]
            ],
            //'created_by',
            [
                'attribute' => 'created_at',
                'value' => function ($model) {
                    return Tool::getElapsedTime($model->created_at);
                },
                'filter' => false
            ],
            //'updated_by',
            //'updated_at',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{delete}'
            ],
        ],
    ]);
    ?>


</div>
