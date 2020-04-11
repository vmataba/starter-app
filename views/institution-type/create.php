<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\InstitutionType */

$this->title = 'New Institution Type';
$this->params['breadcrumbs'][] = ['label' => 'Institution Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="institution-type-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
