<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Salutation */

$this->title = 'Update Salutation: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Salutations', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="salutation-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
