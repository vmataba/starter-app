<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\assets\DataDefinition;
?>
<style>

    li{
        margin-top: 10px
    }

</style>

<div class="row">
    <div class="col-md-6">
        <div class="panel">
            <div class="panel-heading">
                <div class="panel-title">
                    <h4>Assign New Route</h4>
                </div>
            </div>
            <div class="panel-body">
                <?php
                $form = ActiveForm::begin()
                ?>

                <div class="form-group">
                    <?= $form->field($canPerform, 'system_route_id')->dropDownList($model->getFreeRoutes(), ['prompt' => 'Select...']) ?>
                </div>

                <div class="form-group">
                    <?= $form->field($canPerform, 'is_active')->checkbox() ?>
                </div>

                <?= Html::submitButton('Save', ['class' => 'btn btn-sm btn-success']) ?>

                <?php
                ActiveForm::end();
                ?>
            </div>

        </div>
    </div>
    <div class="col-md-6">
        <div class="panel">
            <div class="panel-heading">
                <div class="panel-title">
                    <h4>Add New Member</h4>
                </div>
            </div>
            <div class="panel-body">
                <?php
                $memberForm = ActiveForm::begin()
                ?>

                <div class="form-group">
                    <?= $memberForm->field($groupMember, 'user_id')->dropDownList($model->getFreeUsers(), ['prompt' => 'Select...']) ?>
                </div>

                <div class="form-group">
                    <?= $memberForm->field($groupMember, 'is_active')->checkbox() ?>
                </div>

                <?= Html::submitButton('Save', ['class' => 'btn btn-sm btn-success']) ?>

                <?php
                ActiveForm::end();
                ?>
            </div>

        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 srollable">
        <?php if (!$model->hasRoutes()): ?>

            <div class="panel">
                <div class="panel-body text-warning">
                    <span class="glyphicon glyphicon-trash"></span>
                    This group has not been assigned any action
                </div>
            </div>

        <?php else: ?>
            <div class="panel">
                <div class="panel-heading">
                    <div class="panel-title">
                        <h3>
                            <span class="lnr lnr-magic-wand"></span>
                            Assigned Actions
                        </h3>
                    </div>
                </div>
                <div class="panel-body">
                    <input type="text" class="form-control search-box" id="inputSearchRoutes" placeholder="Search..."/>
                    <ol class="assigned-group-list" id="routesList">
                        <?php foreach ($model->getRoutes() as $route): ?>
                            <li>
                                <span class="item-name"><?= $route->getRoute()->pretty_name ?></span>
                                <span class="pull-right">

                                    <?php if ($route->is_active === DataDefinition::BOOLEAN_TYPE_YES): ?>

                                        <?=
                                        Html::a("<i class='glyphicon glyphicon-off'></i>", ['deactivate-assignment', 'id' => $model->id, 'assignmentId' => $route->id], [
                                            'data' => [
                                                'type' => 'post',
                                                'confirm' => 'Are you sure?'
                                            ],
                                            'class' => 'text-success',
                                            'title' => 'Deactivate'
                                        ])
                                        ?>
                                    <?php else: ?>
                                        <?=
                                        Html::a("<i class='glyphicon glyphicon-off'></i>", ['activate-assignment', 'id' => $model->id, 'assignmentId' => $route->id], [
                                            'data' => [
                                                'type' => 'post',
                                                'confirm' => 'Are you sure?'
                                            ],
                                            'class' => 'text-danger',
                                            'title' => 'Activate'
                                        ])
                                        ?>
                                    <?php endif; ?>

                                </span>
                            </li>
                        <?php endforeach; ?>
                    </ol>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <div class="col-md-6 srollable">
        <?php if (!$model->hasMembers()): ?>

            <div class="panel">
                <div class="panel-body text-warning">
                    <span class="glyphicon glyphicon-trash"></span>
                    This group has not been assigned any member
                </div>
            </div>

        <?php else: ?>
            <div class="panel">
                <div class="panel-heading">
                    <div class="panel-title">
                        <h3>
                            <span class="lnr lnr-users"></span>
                            Assigned Users
                        </h3>
                    </div>
                </div>
                <div class="panel-body">
                    <input type="text" class="form-control" id="inputSearchUsers" placeholder="Search..."/>
                    <ol class="assigned-group-list" id="usersList">
                        <?php foreach ($model->getMembers() as $member): ?>
                            <li>
                                <span class="item-name"><?= $member->getUser()->getFullName() ?></span>
                                <span class="pull-right">

                                    <?php if ($member->is_active === DataDefinition::BOOLEAN_TYPE_YES): ?>

                                        <?=
                                        Html::a("<i class='glyphicon glyphicon-off'></i>", ['deactivate-member', 'id' => $model->id, 'membershipId' => $member->id], [
                                            'data' => [
                                                'type' => 'post',
                                                'confirm' => 'Are you sure?'
                                            ],
                                            'class' => 'text-success',
                                            'title' => 'Deactivate'
                                        ])
                                        ?>
                                    <?php else: ?>
                                        <?=
                                        Html::a("<i class='glyphicon glyphicon-off'></i>", ['activate-member', 'id' => $model->id, 'membershipId' => $member->id], [
                                            'data' => [
                                                'type' => 'post',
                                                'confirm' => 'Are you sure?'
                                            ],
                                            'class' => 'text-danger',
                                            'title' => 'Activate'
                                        ])
                                        ?>
                                    <?php endif; ?>

                                </span>
                            </li>
                        <?php endforeach; ?>
                    </ol>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>


<script>
    const routesList = $('#routesList').html();
    const usersList = $('#usersList').html();

    $('#inputSearchRoutes').keyup(() => {
        let text = $('#inputSearchRoutes').val();
        search(text, 'routesList');
    });
    $('#inputSearchUsers').keyup(() => {
        let text = $('#inputSearchUsers').val();
        search(text, 'usersList');
    });

    function search(keyword, listId) {
        if (keyword.trim().length > 0) {
            $(`#${listId}`).children().each((index, routeItem) => {
                let prettyName = routeItem.getElementsByClassName('item-name')[0].innerHTML;
                if (!prettyName.toLowerCase().includes(keyword.toLowerCase())) {
                    routeItem.style.display = 'none';
                } else {
                    routeItem.style.display = 'list-item';
                }
            });
        } else {
            switch (listId) {
                case 'routesList':
                    $('#routesList').html(routesList);
                    break;
                case 'usersList':
                    $('#usersList').html(usersList);
                    break;
            }
        }
    }

    $(document).ready(() => {
        const height = $('body').height() * 0.8;
        $('.srollable').height(height);
        $('.srollable').css('overflow-y', 'scroll');
        $('#inputSearchRoutes').css('margin-left', $('li').css('margin-left'));


    });
</script>

