<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\InstitutionType;
use app\models\InstitutionStructure;

/* @var $this yii\web\View */
/* @var $model app\models\InstitutionStructure */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="institution-structure-form">

    <?php
    $form = ActiveForm::begin([
                'options' => [
                    'enctype' => 'multipart/form-data'
                ]
    ]);
    ?>

    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'institution_type_id')->dropDownList(InstitutionType::getTypes(), ['prompt' => 'Select...']) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'institution_name')->textInput(['maxlength' => true, 'placeholder' => 'Enter name...']) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'institution_acronym')->textInput(['maxlength' => true, 'placeholder' => 'Enter acronym...']) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'code')->textInput(['maxlength' => true, 'placeholder' => 'Enter code...']) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'parent_institution_structure_id')->dropDownList(InstitutionStructure::getStructures(), ['prompt' => 'Select...', 'id' => 'parent']) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'phone')->textInput(['maxlength' => true, 'placeholder' => 'Enter phone number...']) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'fax')->textInput(['maxlength' => true, 'placeholder' => 'Fax...']) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'placeholder' => 'Email address...']) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?php //$form->field($contract, 'institution_structure_id')->dropDownList(InstitutionStructure::getStructures(), ['prompt' => 'Select...', 'id' => 'institution_structure', 'prompt' => 'Select...']) ?>
            <div class="dropdown" id="structuresDropDownMain">
                <button class="btn btn-sm form-control" type="button" id="institutionStructuresDropDown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" style="display: none">
                    <a href="<?= !true ? '#' : '#' ?>"> <b id="defaultPageLabel"><?= !false ? '<i class="glyphicon glyphicon-trash"></i> No page has been assigned' : "<i class='glyphicon glyphicon-link'></i>&nbsp;&nbsp;" . 'Sample Name' ?></b></a>
                </button>
                <div class="dropdown-menu" aria-labelledby="institutionStructuresDropDown" style="width: 100%">
                    <input type="text" class="form-control search-box" id="inputSearchStructure" placeholder="Search..." style="display: none"/>
                    <style>
                        li {
                            margin: 3px
                        }
                    </style>

                    <?php echo InstitutionStructure::findOne(['parent_institution_structure_id' => InstitutionStructure::NO_PARENT])->printChildren(false); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'website')->textInput(['maxlength' => true, 'placeholder' => 'Website link...']) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'post_office_box')->textInput(['maxlength' => true, 'placeholder' => 'Post box office number...']) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'country')->textInput(['maxlength' => true, 'placeholder' => 'Country...']) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'region')->textInput(['maxlength' => true, 'placeholder' => 'Region...']) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <label>Institution Logo</label>
            <i class="glyphicon glyphicon-pencil" style="cursor: pointer;display: inline-block" title="Edit Institution Logo" id="changeLogo"></i>

            <input type="file" id="nativeLogoInput" name="nativeLogoInput" accept=".jpg, .jpeg, .png" style="display: none"/>

            <br>


            <img src="<?= $model->logo ?>" style="width: 250px; height: 300px;" id="imagePreview" class="img img-responsive"/>

        </div>
        <div class="col-md-3">
            <label>Institution Logo2</label>
            <i class="glyphicon glyphicon-pencil" style="cursor: pointer;display: inline-block" title="Edit Institution Logo 2" id="changeLogo2"></i>

            <input type="file" id="nativeLogo2Input" name="nativeLogo2Input" accept=".jpg, .jpeg, .png" style="display: none"/>

            <br>


            <img src="<?= $model->logo2 ?>" style="width: 250px; height: 300px;" id="imagePreview2" class="img img-responsive"/>
        </div>
    </div>

    <div class="form-group">
        <?= $form->field($model, 'is_active')->checkbox() ?>
    </div>


    <?php //$form->field($model, 'logo')->textInput(['maxlength' => true]) ?>

    <?php //$form->field($model, 'logo2')->textInput(['maxlength' => true])  ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>

    $(document).ready(() => {

        $('#parent').hover(() => {
            //$('#parentModalCenter').modal('show');
            $('#structuresDropDownMain').addClass('open');
            $('li').click((event) => {
                let id = parseInt(event.target.id.replace('structure-', ''));
                if (event.target.id.startsWith("span")) {
                    id = parseInt(event.target.id.replace('span-', ''));
                }
                $('#parent').val(id);
                $('#parentModalCenter').modal('hide');
            });
        });


        /*Upload Logo*/
        $('#changeLogo').click(() => {
            $('#nativeLogoInput').click();
        });

        /*Upload Logo 2*/
        $('#changeLogo2').click(() => {
            $('#nativeLogo2Input').click();
        });

        /*Native file input change*/
        $('#nativeLogoInput').change((event) => {
            const reader = new FileReader();
            reader.onload = (e) => {
                $('#imagePreview').attr('src', e.target.result);
            };
            reader.readAsDataURL(event.target.files[0]);
        });

        /*Native file input change*/
        $('#nativeLogo2Input').change((event) => {
            const reader = new FileReader();
            reader.onload = (e) => {
                $('#imagePreview2').attr('src', e.target.result);
            };
            reader.readAsDataURL(event.target.files[0]);
        });
    });
</script>