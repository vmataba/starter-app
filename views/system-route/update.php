<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SystemRoute */

$this->title = 'Update System Route: ' . $model->pretty_name;
$this->params['breadcrumbs'][] = ['label' => 'System Routes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->pretty_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="system-route-update">

    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
