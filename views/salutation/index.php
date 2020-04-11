<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\assets\DataDefinition;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SalutationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User Salutations';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="salutation-index">
    <p>
        <?= Html::a('Create Salutation', ['create'], ['class' => 'btn btn-success btn-sm']) ?>
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
                'attribute' => 'name',
                'filterInputOptions' => [
                    'placeholder' => 'Search...',
                    'class' => 'form-control'
                ]
            ],
            [
                'attribute' => 'description',
                'filterInputOptions' => [
                    'placeholder' => 'Search...',
                    'class' => 'form-control'
                ]
            ],
            //'created_at',
            //'created_by',
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
            //'updated_at',
            //'updated_by',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{delete}'
            ]
        ],
    ]);
    ?>


</div>
