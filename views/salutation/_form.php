<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\assets\DataDefinition;

/* @var $this yii\web\View */
/* @var $model app\models\Salutation */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="salutation-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Enter name...']) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'description')->textInput(['maxlength' => true, 'placeholder' => 'Enter description...']) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($model, 'is_active')->checkbox([]) ?>  
        </div>
    </div>





    <?php //$form->field($model, 'created_at')->textInput() ?>

    <?php //$form->field($model, 'created_by')->textInput() ?>

    <?php //$form->field($model, 'updated_at')->textInput() ?>

    <?php //$form->field($model, 'updated_by')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-sm']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
