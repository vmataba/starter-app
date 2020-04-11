<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\FileType */

$this->title = 'New File Type';
$this->params['breadcrumbs'][] = ['label' => 'File Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="file-type-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
