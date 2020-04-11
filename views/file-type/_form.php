<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\FileType */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="file-type-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Enter File Type Name...','id' => 'name']) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'code')->textInput(['maxlength' => true, 'placeholder' => 'Will be atomatically generated','id' => 'code','readonly' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'path')->textInput(['maxlength' => true, 'placeholder' => 'Enter File Upload Path...']) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'accepted_types')->textInput(['maxlength' => true, 'placeholder' => 'Enter Accepted Files Types...']) ?>
        </div>
    </div>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true, 'placeholder' => 'Enter Description...']) ?>

    <?= $form->field($model, 'is_active')->checkbox() ?>

    <?php //$form->field($model, 'created_at')->textInput() ?>

    <?php //$form->field($model, 'created_by')->textInput() ?>

    <?php //$form->field($model, 'updated_at')->textInput() ?>

    <?php //$form->field($model, 'updated_by')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script>
    function generateCode() {
        const name = $('#name').val().replace(/ /g,'_');
        const code = `CODE_${name}`.toUpperCase();
        $('#code').val(code);
    }
    $(document).ready(() => {
        if (parseInt("<?= $model->isNewRecord ?>") !== 1) {
            generateCode();
        }
        $('#name').keyup(() => {
            generateCode();
        });
    });
</script>