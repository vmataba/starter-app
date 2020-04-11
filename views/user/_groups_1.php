<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\assets\DataDefinition;
?>
<style>

    li{
        margin-top: 10px
    }
    .assigned-group-list{
        margin-top: -25px
    }
</style>

<?php if (!$model->hasGroups()): ?>

    <div class="panel">
        <div class="panel-body text-warning">
            <span class="glyphicon glyphicon-trash"></span>
            This user is not belonging to any group
        </div>
    </div>

<?php else: ?>
    <div class="panel">
        <div class="panel-heading">
            <div class="panel-title">
                <h3>
                    <span class="lnr lnr-users"></span>
                    Assigned Groups
                </h3>
            </div>
        </div>
        <div class="panel-body">
            <ol class="assigned-group-list">
                <?php foreach ($model->getGroups() as $group): ?>
                    <li>
                        <?= $group->getGroup()->name ?>
                        <span class="pull-right">

                            <?php if ($group->is_active === DataDefinition::BOOLEAN_TYPE_YES): ?>

                                <?=
                                Html::a("<i class='glyphicon glyphicon-off'></i>", ['deactivate-group', 'id' => $model->id, 'membershipId' => $group->id], [
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
                                Html::a("<i class='glyphicon glyphicon-off'></i>", ['activate-group', 'id' => $model->id, 'membershipId' => $group->id], [
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

<div class="panel">
    <div class="panel-heading">
        <div class="panel-title">
            <h4>Assign New Group</h4>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $form = ActiveForm::begin()
        ?>

        <div class="form-group">
            <?= $form->field($isMember, 'group_id')->dropDownList($model->getFreeGroups(), ['prompt' => 'Select...']) ?>
        </div>

        <div class="form-group">
            <?= $form->field($isMember, 'is_active')->checkbox() ?>
        </div>

        <?= Html::submitButton('Save', ['class' => 'btn btn-sm btn-success']) ?>

        <?php
        ActiveForm::end();
        ?>
    </div>

</div>


