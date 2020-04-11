<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\assets\DataDefinition;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserGroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User Groups';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-group-index">

    <p>
        <?= Html::a('Create User Group', ['create'], ['class' => 'btn btn-sm']) ?>
        <?php Html::a("<i class='glyphicon glyphicon-refresh'></i>", ['update-indexes'], ['class' => 'btn btn-sm', 'title' => 'Update Indexs']) ?>
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
                'attribute' => 'code',
                'filterInputOptions' => [
                    'placeholder' => 'Search...',
                    'class' => 'form-control'
                ]
            ],
            [
                'attribute' => 'name',
                'filterInputOptions' => [
                    'placeholder' => 'Search...',
                    'class' => 'form-control'
                ],
                'value' => function ($model) {
                    if ($model->countMembers() === 1) {
                        return $model->name . "&nbsp;<b>(" . $model->countMembers() . " User)</b>";
                    } else {
                        return $model->name . "&nbsp;<b>(" . $model->countMembers() . " Users)</b>";
                    }
                },
                'format' => 'raw'
            ],
            [
                'attribute' => 'description',
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
                'format' => 'raw',
                'filter' => DataDefinition::getBooleanStatuses(),
                'filterInputOptions' => [
                    'prompt' => 'Select...',
                    'class' => 'form-control'
                ]
            ]
            ,
            //'created_at',
            //'created_by',
            //'updated_at',
            //'updated_by',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}{update}'
            ]
        ],
    ]);
    ?>


</div>
