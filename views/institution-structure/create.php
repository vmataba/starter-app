<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\InstitutionStructure */

$this->title = 'New Institution Structure';
$this->params['breadcrumbs'][] = ['label' => 'Institution Structures', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="institution-structure-create">
    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
