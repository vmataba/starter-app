<?php

use yii\widgets\DetailView;
use app\assets\DataDefinition;
use app\assets\tools\Tool;
?>

<img src="<?= $model->photo ?>" style="height: 100px; width: 100px" class="img img-circle"/>&nbsp 

<?=
DetailView::widget([
    'model' => $model,
    'attributes' => [
        //'id',
        [
            'attribute' => 'username',
            'value' => $model->username
            ,
            'format' => 'raw'
        ],
        //'password',
        //'auth_key',
        //'access_token',
        [
            'attribute' => 'salutation',
            'value' => $model->getSalutation()->name
        ],
        'first_name',
        'middle_name',
        'surname',
        'phone',
        'email:email',
        //'photo',
        [
            'attribute' => 'company_level',
            'value' => $model->getTitle()->name
        ],
        [
            'attribute' => 'is_active',
            'value' => DataDefinition::getStyledBooleanTypes()[$model->is_active],
            'format' => 'raw'
        ],
        [
            'attribute' => 'last_login',
            'value' => $model->last_login === null ? 'Never' : Tool::getElapsedTime($model->last_login)
        ],
    //'created_at',
    //'created_by',
    //'updated_at',
    //'updated_by',
    ],
])
?>