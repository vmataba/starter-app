<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\FileTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'File Types';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="file-type-index">


    <p>
        <?= Html::a('Create File Type', ['create'], ['class' => 'btn btn-success btn-sm']) ?>
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
                ]
            ],
            [
                'attribute' => 'description',
                'filterInputOptions' => [
                    'placeholder' => 'Search...',
                    'class' => 'form-control'
                ]
            ],
            [
                'attribute' => 'path',
                'filterInputOptions' => [
                    'placeholder' => 'Search...',
                    'class' => 'form-control'
                ]
            ],
            //'accepted_types',
            //'is_active',
            //'created_at',
            //'created_by',
            //'updated_at',
            //'updated_by',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    ?>


</div>
