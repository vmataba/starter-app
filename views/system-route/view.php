<?php

use yii\helpers\Html;
use app\assets\DataDefinition;

/* @var $this yii\web\View */
/* @var $model app\models\SystemRoute */

$this->title = $model->pretty_name;
$this->params['breadcrumbs'][] = ['label' => 'System Routes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="system-route-view">

    <p>
        <?= Html::a("<i class='glyphicon glyphicon-pencil'></i>", ['update', 'id' => $model->id], ['class' => 'btn btn-sm', 'title' => 'Update']) ?>
        <?=
        $model->canBeDeleted() ? "" :
                Html::a('<i class=\'glyphicon glyphicon-trash text-danger\'></i>', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-sm',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ])
        ?>
    </p>


    <div class="panel">
        <div class="panel-body">
            <table class="table">
                <tr>
                    <th style='border-top: none'>Module</th>
                    <td style='border-top: none'><?= empty($model->module) ? '(not set)' : '<code>'.$model->module.'</code>' ?></td>
                </tr>

                <tr>
                    <th>Controller</th>
                    <td><code><?= $model->controller ?></code></td>
                </tr>
                <tr>
                    <th>Action</th>
                    <td><code><?= $model->action ?></code></td>
                </tr>
                <tr>
                    <th>Pretty name</th>
                    <td><?= $model->pretty_name ?></td>
                </tr>
                <tr>
                    <th>Is active</th>
                    <td><?= DataDefinition::getStyledBooleanTypes()[$model->is_active] ?></td>
                </tr>
                <tr>
                    <th>Created at</th>
                    <td><?= $model->created_at ?></td>
                </tr>
                <tr>
                    <th>Created by</th>
                    <td><?= empty($model->created_by) ? '(not set)' : $model->getCreatedBy()->getFullName() ?></td>
                </tr>
                <tr>
                    <th>Updated at</th>
                    <td><?= empty($model->updated_at) ? '(not set)' : $model->updated_at ?></td>
                </tr>
                <tr>
                    <th>Updated by</th>
                    <td><?= empty($model->updated_by) ? '(not set)' : $model->getUpdatedBy()->getFullName() ?></td>
                </tr>

            </table>
        </div>
    </div>    


</div>
