<?php

/* @var $this yii\web\View */
/* @var $model app\models\Institution */

$this->title = 'Update Institution: ' . $model->institution_name;
//$this->params['breadcrumbs'][] = ['label' => 'Institutions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->institution_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="institution-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
