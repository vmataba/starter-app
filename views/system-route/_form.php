<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SystemRoute */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="system-route-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'module', ['enableAjaxValidation' => true])->textInput(['maxlength' => true, 'placeholder' => '(Optional) Example app']) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'controller', ['enableAjaxValidation' => true])->textInput(['maxlength' => true, 'placeholder' => 'Example site']) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'action', ['enableAjaxValidation' => true])->textInput(['maxlength' => true, 'placeholder' => 'Example index']) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'pretty_name', ['enableAjaxValidation' => true])->textInput(['maxlength' => true, 'placeholder' => 'Example Add New Item']) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'is_active')->checkbox() ?>
        </div>
    </div>



    <?php //$form->field($model, 'created_at')->textInput() ?>

    <?php //$form->field($model, 'created_by')->textInput() ?>

    <?php //$form->field($model, 'updated_at')->textInput() ?>

    <?php //$form->field($model, 'updated_by')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
