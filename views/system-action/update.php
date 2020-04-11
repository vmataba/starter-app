<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SystemAction */

$this->title = 'Update System Action: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'System Actions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="system-action-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
