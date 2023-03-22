<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model app\models\Institution */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="institution-form">

    <?php
    $form = ActiveForm::begin([
                'options' => [
                    'enctype' => 'multipart/form-data'
                ]
    ]);
    ?>

    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'institution_name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'institution_code')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'subsp_code')->textInput() ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'logo_height')->textInput(['type' => 'number', 'min' => 100, 'id' => 'logo_height', 'onchange' => 'resizeLogo()']) ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'logo_width')->textInput(['type' => 'number', 'min' => 100, 'id' => 'logo_width', 'onchange' => 'resizeLogo()']) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <label>Logo</label>
            <i class="glyphicon glyphicon-pencil" style="cursor: pointer;display: inline-block" title="Edit Institution Logo" id="changeLogo"></i>

            <input type="file" id="nativeFileInput" name="nativeFileInput" accept=".jpg, .jpeg, .png" style="display: none"/>

            <br>


            <img src="<?= Yii::$app->request->baseUrl.'/'. $model->logo ?>" style="width: 100%; height: 300px;" id="imagePreview" class="img img-responsive"/>


            <?php //$form->field($model, 'photo')->textInput(['maxlength' => true])      ?>
        </div>
    </div>
    <br>


    <?php //$form->field($model, 'logo')->textInput(['maxlength' => true])  ?>




    <?php //$form->field($model, 'home_page')->textarea(['rows' => 6])  ?>

    <div class="row">
        <div class="col-md-6">
            <?=
            $form->field($model, 'contact_details')->widget(CKEditor::className(), [
                'options' => ['rows' => 6],
                    //'preset' => 'basic'
            ])
            ?>
        </div>
        <div class="col-md-6">
            <?=
            $form->field($model, 'home_page')->widget(CKEditor::className(), [
                'options' => ['rows' => 6],
                    //'preset' => 'basic'
            ])
            ?>

        </div>
    </div>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>

    function resizeLogo() {

        let height = $('#logo_height').val();
        let width = $('#logo_width').val();
        $('#imagePreview').width(width);
        $('#imagePreview').height(height);
    }

    $(document).ready(() => {

        resizeLogo();

        /*Upload Profile picture*/
        $('#changeLogo').click(() => {
            $('#nativeFileInput').click();
        });

        /*Native file input change*/
        $('#nativeFileInput').change((event) => {
            const reader = new FileReader();
            reader.onload = (e) => {
                $('#imagePreview').attr('src', e.target.result);
            };
            reader.readAsDataURL(event.target.files[0]);
        })
    });
</script>