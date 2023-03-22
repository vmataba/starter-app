<?php

use app\assets\DataDefinition;
use app\models\User;
use app\assets\tools\Tool;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'My Profile';
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<?php
/*
 * Current user
 */
$currentUser = User::findOne(Yii::$app->user->id);
?>

<div class="user-view">
    <div class="panel">
        <div class="panel-body">
            <table class="table">
                <tr>
                    <td colspan="2" align="center" style="border-top: none">
                        <img src="<?= Yii::$app->request->baseUrl.'/'. $model->photo ?>" style="width: 100px; height: 100px" class="img img-circle"/>
                        <label class="label label-info" style="font-size: 1em; border-radius: 30px"><?= $model->getFullName() ?></label>
                    </td>
                </tr>
                <tr>
                    <th style="border-top: none">Username</th>
                    <td style="border-top: none"><?= $model->username ?></td>
                </tr>
                <tr>
                    <th>First name</th>
                    <td><?= $model->first_name ?></td>
                </tr>
                <tr>
                    <th>Middle name</th>
                    <td><?= empty($model->middle_name) ? '(not set)' : $model->middle_name ?></td>
                </tr>
                <tr>
                    <th>Surname</th>
                    <td><?= $model->surname ?></td>
                </tr>
                <tr>
                    <th>Phone number</th>
                    <td><?= $model->phone ?></td>
                </tr>
                <tr>
                    <th>Email address</th>
                    <td><?= $model->email ?></td>
                </tr>
                <tr>
                    <th>Account Password</th>
                    <td>
                        <button class="btn btn-sm round-input" id="btn_update_password" onclick="validateCurrentPassword()">Update</button>
                    </td>
                </tr>
                <tr>
                    <th>User groups</th>
                    <td><?= $model->getNamedGroups() ?></td>
                </tr>
                <tr>
                    <th>Last login</th>
                    <td><?= $model->last_login === null ? 'Never' : Tool::getFormattedDate($model->last_login, true) ?></td>
                </tr>
                <tr>
                    <th>Is Active</th>
                    <td><?= DataDefinition::getStyledBooleanTypes()[$model->is_active] ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalCurrentPassword" tabindex="-1" role="dialog" aria-labelledby="modalCurrentPasswordTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <img src="<?= $model->getPhoto() ?>" style="width: 50px; height: 50px" class="img img-circle"/>
                <h5 style="display: inline">Current Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <?php $form = ActiveForm::begin() ?>

                <?= $form->field($currentPassword, 'password')->passwordInput(['id' => 'current_password', 'placeholder' => 'Enter your current password...', 'class' => 'form-control round-input']) ?>
                <input type="submit" id="submit_password" value="Submit" style="display:none"/>
                <?php ActiveForm::end() ?>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm" data-dismiss="modal"> <b><i class="glyphicon glyphicon-remove"></i></b> Close</button>
                <button type="button" class="btn btn-sm" id="btn_proceed"><b><i class="glyphicon glyphicon-arrow-right"></i></b> Proceed</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(() => {
        $('#btn_proceed').click(() => {
            $('#submit_password').click();
        });
        if (parseInt("<?= isset($showCurrentPasswordModal) && $showCurrentPasswordModal ?>") === 1) {
            $('#modalCurrentPassword').modal('show');
        }
    });
    function validateCurrentPassword() {

        $('#modalCurrentPassword').modal('show');
    }
</script>