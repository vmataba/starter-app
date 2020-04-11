<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Salutation;
use app\assets\DataDefinition;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>
<?php
/*
 * Current user
 */
$currentUser = User::findOne(Yii::$app->user->id);
?>



<div class="user-form">

    <?php
    $form = ActiveForm::begin([
                'options' => [
                    'enctype' => 'multipart/form-data'
                ]
    ]);
    ?>

    <div class="row">
        <div class="col-md-6">

            <div class="row">
                <div class="col-md-4">
                    <?= $form->field($model, 'salutation')->dropDownList(Salutation::getSalutations(), ['prompt' => 'Select...']) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true, 'placeholder' => 'Enter username']) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'middle_name')->textInput(['maxlength' => true, 'placeholder' => 'Enter middle name']) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'surname')->textInput(['maxlength' => true, 'placeholder' => 'Enter surname']) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'phone')->textInput(['maxlength' => true, 'placeholder' => 'Enter phone number']) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'placeholder' => 'Enter email address']) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'username')->textInput(['maxlength' => true, 'placeholder' => 'Enter username']) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Leave blank for default']) ?>
                </div>
                <div class="col-md-12">
                    <?= $form->field($model, 'is_active')->checkbox(['class' => 'checkbox']) ?>
                    <?php //$form->field($model, 'is_active')->dropDownList(DataDefinition::getBooleanTypes()) ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-sm-12">
                    <label>Profile Picture</label>
                    <input type="file" id="nativeFileInput" name="nativeFileInput" accept=".jpg, .jpeg, .png" style="display: none"/>

                    <span>
                        <i class="glyphicon glyphicon-pencil" style="cursor: pointer" title="Edit Profile Picture" id="changePhoto"></i>
                    </span>
                    <br>
                    <img src="<?= $model->photo ?>" style="width: 200px; height: 200px;" id="imagePreview" class=""/>


                    <?php //$form->field($model, 'photo')->textInput(['maxlength' => true])   ?>
                </div>
            </div>
        </div>
    </div>











    <?php //$form->field($model, 'auth_key')->textInput(['maxlength' => true]) ?>

    <?php //$form->field($model, 'access_token')->textInput(['maxlength' => true])  ?>


    <?php //$form->field($model, 'last_login')->textInput() ?>

    <?php //$form->field($model, 'created_at')->textInput() ?>

    <?php //$form->field($model, 'created_by')->textInput() ?>

    <?php //$form->field($model, 'updated_at')->textInput() ?>

    <?php //$form->field($model, 'updated_by')->textInput()  ?>
    <br>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <script>

        $(document).ready(() => {
            /*Upload Profile picture*/
            $('#changePhoto').click(() => {
                $('#nativeFileInput').click();
            });

            /*Native file input change*/
            $('#nativeFileInput').change((event) => {
                const reader = new FileReader();
                reader.onload = (e) => {
                    $('#imagePreview').attr('src', e.target.result);
                };
                reader.readAsDataURL(event.target.files[0]);
            });
        });

    </script>


</div>
