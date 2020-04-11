<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Salutation */

$this->title = 'New Salutation';
$this->params['breadcrumbs'][] = ['label' => 'Salutations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="salutation-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
