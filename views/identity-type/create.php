<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\IdentityType */

$this->title = 'Create Identity Type';
$this->params['breadcrumbs'][] = ['label' => 'Identity Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="identity-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
