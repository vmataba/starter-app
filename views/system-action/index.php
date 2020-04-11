<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SystemActionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'System Actions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="system-action-index">

    <p>
        <?= Html::a('Create System Action', ['create'], ['class' => 'btn btn-success btn-sm']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'id',
            'name',
            'url:url',
            'is_active',
            //'created_at',
            //'created_by',
            //'updated_at',
            //'updated_by',
            [
                'class' => 'yii\grid\ActionColumn',
            ]
        ],
    ]);
    ?>


</div>
