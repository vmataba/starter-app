<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\InstitutionSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="institution-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'institution_code') ?>

    <?= $form->field($model, 'subsp_code') ?>

    <?= $form->field($model, 'institution_name') ?>

    <?= $form->field($model, 'logo') ?>

    <?php // echo $form->field($model, 'logo_height') ?>

    <?php // echo $form->field($model, 'logo_width') ?>

    <?php // echo $form->field($model, 'banner') ?>

    <?php // echo $form->field($model, 'instructions') ?>

    <?php // echo $form->field($model, 'instructions_pg') ?>

    <?php // echo $form->field($model, 'contact_details') ?>

    <?php // echo $form->field($model, 'home_page') ?>

    <?php // echo $form->field($model, 'pay_bank_instructions') ?>

    <?php // echo $form->field($model, 'pay_bank_instructions_pg') ?>

    <?php // echo $form->field($model, 'min_prog_direct') ?>

    <?php // echo $form->field($model, 'max_prog_direct') ?>

    <?php // echo $form->field($model, 'min_prog_equivalent') ?>

    <?php // echo $form->field($model, 'max_prog_equivalent') ?>

    <?php // echo $form->field($model, 'min_programme') ?>

    <?php // echo $form->field($model, 'max_programme') ?>

    <?php // echo $form->field($model, 'support_email1') ?>

    <?php // echo $form->field($model, 'support_email2') ?>

    <?php // echo $form->field($model, 'support_email3') ?>

    <?php // echo $form->field($model, 'support_phone1') ?>

    <?php // echo $form->field($model, 'support_phone2') ?>

    <?php // echo $form->field($model, 'support_phone3') ?>

    <?php // echo $form->field($model, 'applicant_home_page') ?>

    <?php // echo $form->field($model, 'application_deadline') ?>

    <?php // echo $form->field($model, 'activate_account_email') ?>

    <?php // echo $form->field($model, 'referee_email') ?>

    <?php // echo $form->field($model, 'application_close_reminder') ?>

    <?php // echo $form->field($model, 'not_selected_email') ?>

    <?php // echo $form->field($model, 'selected_email') ?>

    <?php // echo $form->field($model, 'payment_confirmed_email') ?>

    <?php // echo $form->field($model, 'account_activated_message') ?>

    <?php // echo $form->field($model, 'banner_color') ?>

    <?php // echo $form->field($model, 'application_status') ?>

    <?php // echo $form->field($model, 'application_status_remarks') ?>

    <?php // echo $form->field($model, 'application_status_pg') ?>

    <?php // echo $form->field($model, 'application_status_remarks_pg') ?>

    <?php // echo $form->field($model, 'tcu_username') ?>

    <?php // echo $form->field($model, 'tcu_key') ?>

    <?php // echo $form->field($model, 'current_round') ?>

    <?php // echo $form->field($model, 'confirmation_status') ?>

    <?php // echo $form->field($model, 'admiss_letter_ug') ?>

    <?php // echo $form->field($model, 'admiss_letter_pg') ?>

    <?php // echo $form->field($model, 'publish_status_pg') ?>

    <?php // echo $form->field($model, 'show_pg_tab') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'closed_by') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
