<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Period */

$this->title = 'Create Period';
$this->params['breadcrumbs'][] = ['label' => 'Periods', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="period-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
