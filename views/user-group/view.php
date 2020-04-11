<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UserGroup */

$this->title = $model->code . ":" . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'User Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-group-view">
    <p>
        <?= Html::a("<i class='glyphicon glyphicon-duplicate'></i>", ['clone', 'id' => $model->id], ['class' => 'btn btn-sm', 'title' => 'Clone']) ?>
        <?= Html::a("<i class='glyphicon glyphicon-pencil'></i>", ['update', 'id' => $model->id], ['class' => 'btn btn-sm', 'title' => 'Update']) ?>
        <?=
        !Yii::$app->session['user']->canView('user-group/delete') ? '' :
                Html::a('<i class=\'glyphicon glyphicon-trash text-danger\'></i>', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-sm',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ])
        ?>
    </p>

    <div class="row">
        <div class="col-md-12">
            <?=
            $this->render('_basic_details', [
                'model' => $model
            ])
            ?>
        </div>
        <div class="col-md-12">
            <?=
            $this->render('_assignments', [
                'model' => $model,
                'canPerform' => $canPerform,
                'groupMember' => $groupMember
            ])
            ?>
        </div>
    </div>


</div>