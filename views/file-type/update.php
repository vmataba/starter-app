<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\FileType */

$this->title = 'Update File Type: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'File Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="file-type-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
