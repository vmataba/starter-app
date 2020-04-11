<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\InstitutionType */

$this->title = 'Update Institution Type: ' . $model->institution_type_name;
$this->params['breadcrumbs'][] = ['label' => 'Institution Types', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="institution-type-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
