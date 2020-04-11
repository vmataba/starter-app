<?php

use yii\widgets\DetailView;
use app\assets\DataDefinition;
?>

<p>
    <?= $model->description ?>
</p>

<?php
DetailView::widget([
    'model' => $model,
    'attributes' => [
        //'id',
        'code',
        'name',
        'description',
        [
            'attribute' => 'is_active',
            'value' => DataDefinition::getStyledBooleanTypes()[$model->is_active],
            'format' => 'raw'
        ],
    //'created_at',
    //'created_by',
    //'updated_at',
    //'updated_by',
    ],
])
?>
