<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SystemAction */

$this->title = 'Create New System Action';
$this->params['breadcrumbs'][] = ['label' => 'System Actions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="system-action-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
