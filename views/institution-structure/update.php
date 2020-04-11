<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\InstitutionStructure */

$this->title = 'Update Institution Structure: ' . $model->institution_name;
$this->params['breadcrumbs'][] = ['label' => 'Institution Structures', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->institution_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="institution-structure-update">
    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
