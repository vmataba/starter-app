<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\assets\DataDefinition;
use app\models\Salutation;
use app\models\Title;
use app\models\User;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'System Users';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
/*
 * Current user
 */
$currentUser = User::findOne(Yii::$app->user->id);
?>

<div class="user-index">



    <p>
        <?= Html::a('Add User', ['create'], ['class' => 'btn btn-success btn-sm']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]);    ?>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'id',
            [
                'attribute' => 'username',
                'value' => function ($model) {
                    $baseUrl = Yii::$app->request->baseUrl;
                    return "<img src='$baseUrl/{$model->photo}' style='height: 50px; width: 50px' class='img img-circle'/>&nbsp;" . $model->username;
                },
                'format' => 'raw',
                'filterInputOptions' => [
                    'placeholder' => 'Search...',
                    'class' => 'form-control'
                ]
            ],
            //'password',
            //'auth_key',
            //'access_token',
            [
                'attribute' => 'salutation',
                'value' => function ($model) {
                    return $model->getSalutation()->name;
                },
                'filter' => Salutation::getSalutations(),
                'filterInputOptions' => [
                    'prompt' => 'Select...',
                    'class' => 'form-control'
                ]
            ],
            [
                'attribute' => 'first_name',
                'filterInputOptions' => [
                    'placeholder' => 'Search...',
                    'class' => 'form-control'
                ]
            ],
            [
                'attribute' => 'middle_name',
                'filterInputOptions' => [
                    'placeholder' => 'Search...',
                    'class' => 'form-control'
                ]
            ],
            [
                'attribute' => 'surname',
                'filterInputOptions' => [
                    'placeholder' => 'Search...',
                    'class' => 'form-control'
                ]
            ],
            [
                'attribute' => 'phone',
                'filterInputOptions' => [
                    'placeholder' => 'Search...',
                    'class' => 'form-control'
                ]
            ],
            [
                'attribute' => 'email',
                'filterInputOptions' => [
                    'placeholder' => 'Search...',
                    'class' => 'form-control'
                ]
            ],
            //'phone',
            //'email:email',
            //'photo',
//            [
//                'attribute' => 'company_level',
//                'value' => function ($model) {
//                    return $model->getCompanyLevel()->getTitle()->name;
//                },
//                'filter' => Title::getTitles()
//            ],
            [
                'attribute' => 'is_active',
                'value' => function ($model) {
                    return DataDefinition::getStyledBooleanTypes()[$model->is_active];
                },
                'filter' => DataDefinition::getBooleanTypes(),
                'format' => 'raw',
                'filterInputOptions' => [
                    'prompt' => 'Select...',
                    'class' => 'form-control'
                ],
            ],
           
            //'last_login',
            //'created_at',
            //'created_by',
            //'updated_at',
            //'updated_by',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => "{view} {update}"
            ],
        ],
    ]);
    ?>


</div>
