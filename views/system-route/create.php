<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SystemRoute */

$this->title = 'New System Route';
$this->params['breadcrumbs'][] = ['label' => 'System Routes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="system-route-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
