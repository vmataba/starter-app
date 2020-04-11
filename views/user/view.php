<?php

use yii\helpers\Html;
use app\assets\DataDefinition;
use yii\widgets\ActiveForm;
use app\assets\tools\Tool;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'User ' . $model->getFullName();
$this->params['breadcrumbs'][] = ['label' => 'System Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<style>
    .select-area input[type=text]{
        border-left:none;
        border-top:none;
        border-right:none;
        border-bottom: 1px solid lavender;
        height: 35px;
        width: 100%;
        margin-top: 2px;
    }
    .select-area li{
        border-left:none; 
        border-top:none; 
        border-right:none;
        border-bottom: 1px solid lavender;
        margin-top: 2px
    }
    .select-area{
        overflow-x: hidden;
        overflow-y: scroll;
        height: 350px
    }
    .dropdown li{
        border-top: none;
        cursor: pointer;
        border-bottom: none
    }
    .dropdown ul{
        width: 100%;

    }
    .dropdown-menu{
        width: 100%;
        border-top: none;
        max-height: 400px;
        overflow-y: scroll
    }
    .dropdown search-box{
        border: none
    }
    .dropdown form-control{
        border-top: none
    }
    .modal-footer button:hover{
        color: green;
    }
    #recovery_password{
        border-radius: 15px
    }
</style>


<div class="user-view">

    <p>
        <?= Html::a("<i class='glyphicon glyphicon-pencil'></i>", ['update', 'id' => $model->id], ['class' => 'btn btn-sm']) ?>
        <?=
        Html::a("<i class='glyphicon glyphicon-trash text-danger'></i>", ['delete', 'id' => $model->id], [
            'class' => 'btn btn-sm',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ])
        ?>
    </p>


    <div class="panel">
        <div class="panel-body">

            <div class="row">
                <div class="col-md-6">

                    <div class="row">

                        <div class="col-md-8" >
                            <table class="table">
                                <tr>
                                    <td colspan="2" align="center" style="border-top: none">
                                        <img src="<?= $model->photo ?>" style="width: 100px; height: 100px; margin-left: auto; margin-right: auto" class="img img-circle"/>
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
                                    <th>User groups</th>
                                    <td><?= $model->getNamedGroups() ?></td>
                                </tr>
                                <tr>
                                    <th>Password Recovery</th>
                                    <td>
                                        <?=
                                        Html::a("<img src='" . Tool::getResetIcon() . "' style='width: 25px; height: 25px'></img>", /* ['reset-password', 'id' => $model->id] */ '#', [
                                            // 'data' => [
                                            //     'confirm' => 'Are you sure?'
                                            // ],
                                            'title' => 'Reset Password',
                                            'data-toggle' => 'modal',
                                            'data-target' => '#modalPasswordRecovery'
                                        ])
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Last login</th>
                                    <td><?= $model->last_login === null ? 'Never' : Tool::getFormattedDate($model->last_login, true) ?></td>
                                </tr>
                                <tr>
                                    <th>Logins</th>
                                    <th><?= $model->countLogins() ?></th>
                                </tr>
                                <tr>
                                    <th style="border: none">Default Page</th>
                                    <td style="border: none">
                                        <?php //Html::dropDownList(null, null, [1 => 'One', 2 => 'Two'], ['class' => 'form-control select', 'id' => 'default_page', 'prompt' => 'Select...']) ?>

                                        <div class="dropdown dropleft">
                                            <button class="btn btn-sm form-control" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                <a href="<?= !$model->hasDefaultPage() ? '#' : '#' ?>"> <b id="defaultPageLabel"><?= !$model->hasDefaultPage() ? '<i class="glyphicon glyphicon-trash"></i> No page has been assigned' : "<i class='glyphicon glyphicon-link'></i>&nbsp;&nbsp;" . $model->getDefaultSystemRoute()->pretty_name ?></b></a>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                                <input type="text" class="form-control search-box" id="inputSearchDefaultRoute" placeholder="Search..."/>
                                                <ul class="list-group" id="default-routes-list">
                                                    <li class="list-group-item">Item 1</li>
                                                    <li class="list-group-item">Item 1</li>
                                                    <li class="list-group-item">Item 1</li>
                                                    <li class="list-group-item">Item 1</li>
                                                </ul>
                                            </div>
                                        </div>

                                    </td>
                                </tr>
                                <tr>
                                    <th style="border: none">Is Active</th>
                                    <td style="border: none"><?= DataDefinition::getStyledBooleanTypes()[$model->is_active] ?></td>
                                </tr>
                            </table>

                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <?=
                    $this->render('_groups', [
                        'model' => $model
                    ])
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalPasswordRecovery" tabindex="-1" role="dialog" aria-labelledby="modalPasswordRecoveryTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="parentModalLongTitle">User Account Password Recovery</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <?php $form = ActiveForm::begin() ?>

                <?= $form->field($recoveryPassword, 'password')->textInput(['id' => 'recovery_password', 'placeholder' => 'Type | User generator...']) ?>
                <input type="submit" id="submit_password" value="Submit" style="display:none"/>
                <?php ActiveForm::end() ?>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm" data-dismiss="modal"> <b><i class="glyphicon glyphicon-remove"></i></b> Close</button>
                <button type="button" class="btn btn-sm" id="btn_save_password"><b><i class="glyphicon glyphicon-save"></i></b> Save Changes</button>
            </div>
        </div>
    </div>
</div>

<script>

    function search(keyword, listId) {
        if (keyword.trim().length > 0) {
            $(`#${listId}`).children().each((index, groupItem) => {
                let prettyName = groupItem.innerHTML;
                if (!prettyName.toLowerCase().includes(keyword.toLowerCase())) {
                    groupItem.style.display = 'none';
                } else {
                    groupItem.style.display = 'list-item';
                }
            });
        } else {
            $(`#${listId}`).children().each((index, groupItem) => {
                if (groupItem.style.display === 'none') {
                    groupItem.style.display = 'list-item';
                }
            });
        }
    }

    $(document).ready(() => {
        $('#inputSearchDefaultRoute').keyup(() => {
            let text = $('#inputSearchDefaultRoute').val();
            search(text, 'default-routes-list');
        });
        /*Recovery Password*/
        $('label[for=recovery_password]').html($('label[for=recovery_password]').html() + `&nbsp;<b>|</b>&nbsp;<i class='icon-key-pass' id='password_generator' style='cursor:pointer' title='Generate password...'></i>`);
        $('#password_generator').click(() => {
            const url = `<?= Url::to(['generate-password']) ?>`;
            $.ajax({
                url,
                success: (response) => {
                    let responseBundle = JSON.parse(response);
                    let password = responseBundle.password;
                    $('#recovery_password').val(password);
                }
            });
        });
        $('#btn_save_password').click(() => {
            $('#submit_password').click();
        });
    });

    /*$(document).ready(() => {
     const nativeSelect = document.getElementsByClassName('select')[0];
     const newSelect = document.createElement('span');
     let newSelectContent = `
     <div class='panel select-area'>
     <div class='panel-body'>
     <input type='text' class='search-box' placeholder='Search...'/>     
     <ul class='list-group'>`;
     let nativeSelectOptions = nativeSelect.getElementsByTagName('option');
     //newSelect.style.height = (10 * nativeSelectOptions.length) + 'px';
     for (let index = 0; index < nativeSelectOptions.length; index++) {
     newSelectContent += `
     <li class='list-group-item'>
     <span>
     <input type='checkbox' class='checkbox'/>
     </span>
     ${nativeSelectOptions[index].innerHTML}
     </li>`;
     }
     
     newSelectContent += `</ul>
     </div>            
     </div>`;
     newSelect.innerHTML = newSelectContent;
     nativeSelect.parentNode.insertBefore(newSelect, nativeSelect.nextSibling);
     });*/
</script>