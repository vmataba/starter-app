<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UserGroup */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-group-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-4">
            <?= $form->field($model, 'code', ['enableAjaxValidation' => true])->textInput(['maxlength' => true, 'readonly' => !$model->isNewRecord, 'placeholder' => 'Will be automatically generated']) ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'name',['enableAjaxValidation' => true])->textInput(['maxlength' => true, 'placeholder' => 'Enter group name']) ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'description')->textInput(['maxlength' => true, 'placeholder' => 'Ennter group description']) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($model, 'is_active')->checkbox(['class' => 'checkbox']) ?>
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
