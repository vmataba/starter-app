<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\InstitutionStructure */

$this->title = $model->institution_name;
$this->params['breadcrumbs'][] = ['label' => 'Institution Structures', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="institution-structure-view">



    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php
//        Html::a('Delete', ['delete', 'id' => $model->id], [
//            'class' => 'btn btn-danger',
//            'data' => [
//                'confirm' => 'Are you sure you want to delete this item?',
//                'method' => 'post',
//            ],
//        ])
        ?>
    </p>


    <?php if ($model->isParent()): ?>

        <div class="row">
            <div class="col-md-6">
                <?= $this->render('_details', ['model' => $model]) ?>
            </div>
            <div class="col-md-6">
                <?= $this->render('_children', ['model' => $model]) ?>
            </div>
        </div>

    <?php else: ?>

        <?= $this->render('_details', ['model' => $model]) ?>

    <?php endif; ?>

</div>
