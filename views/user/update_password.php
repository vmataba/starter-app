<?php

use yii\widgets\ActiveForm
?>



<div class="panel" style="width: 40%; margin-left: auto; margin-right: auto">
    <div class="panel-heading">
        <img src="<?= $model->getPhoto() ?>" style="width: 50px; height: 50px" class="img img-circle"/>
        <h5 style="display: inline">Update your user account password</h5>
    </div>
    <div class="panel-body">
        <?php $form = ActiveForm::begin() ?>
        <?= $form->field($newPassword, 'newPassword')->passwordInput(['id' => 'new_password', 'placeholder' => 'Enter a new password...', 'class' => 'form-control round-input']) ?>
        <?= $form->field($newPassword, 'confirmationPassword')->passwordInput(['id' => 'confirmation_password', 'placeholder' => 'Repeat password...', 'class' => 'form-control round-input']) ?>

        <div class="form-group">
            <button class="btn btn-sm pull-right">
                <i class="glyphicon glyphicon-save"></i>
                &nbsp;
                Save
            </button>
        </div>

        <?php ActiveForm::end() ?>
    </div>
</div>