<?php

use yii\widgets\DetailView;
use app\assets\DataDefinition;
use yii\helpers\Html;
?>

<div class="panel">
    <div class="panel-body">


        <div class="row">

            <div class="col-md-6">
                <h5>Logo 1</h5>
                <img src="<?=  Yii::$app->request->baseUrl.'/'.$model->logo ?>" style="width: 250px; height: 300px;" id="imagePreview2" class="img img-responsive"/>
            </div>
            <div class="col-md-6">
                <h5>Logo 2</h5>
                <img src="<?= Yii::$app->request->baseUrl.'/'.$model->logo2 ?>" style="width: 250px; height: 300px;" id="imagePreview2" class="img img-responsive"/>
            </div>

        </div>
        <br>
        <table class="table">
            <tr>
                <th style="border-top: none">Name</th>
                <td style="border-top: none"><?= $model->institution_name ?></td>
            </tr>
            <tr>
                <th>Acronym</th>
                <td><?= $model->institution_acronym ?></td>
            </tr>
            <tr>
                <th>Code</th>
                <td><?= $model->code ?></td>
            </tr>
            <tr>
                <th>Parent</th>
                <td>
                    <?php
                    if (!$model->hasParent()) {
                        echo "<b>--ROOT--</b>";
                    } else {
                       echo Html::a($model->getParent()->institution_name, ['view', 'id' => $model->parent_institution_structure_id], ['target' => 'blank']);
                    }

                    ?>
                </td>
            </tr>
            <tr>
                <th>Type</th>
                <td><?= $model->getType()->institution_type_name ?></td>
            </tr>
            <tr>
                <th>Phone</th>
                <td><?= $model->phone ?></td>
            </tr>
            <tr>
                <th>Fax</th>
                <td><?= $model->fax ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?= $model->email ?></td>
            </tr>
            <tr>
                <th>Website</th>
                <td><?= $model->website ?></td>
            </tr>
            <tr>
                <th>Post office box</th>
                <td><?= $model->post_office_box ?></td>
            </tr>
            <tr>
                <th>Region</th>
                <td><?= $model->region ?></td>
            </tr>
            <tr>
                <th>Country</th>
                <td><?= $model->country ?></td>
            </tr>
            <tr>
                <th>Is active</th>
                <td><?= DataDefinition::getStyledBooleanTypes()[$model->is_active] ?></td>
            </tr>
        </table>
        <?php
        DetailView::widget([
            'model' => $model,
            'attributes' => [
                // 'id',
                'institution_name',
                'institution_acronym',
                'code',
                [
                    'attribute' => 'parent_institution_structure_id',
                    'value' => function ($model) {
                        if (!$model->hasParent()) {
                            return "<b>--ROOT--</b>";
                        }
                        return Html::a($model->getParent()->institution_name, ['view', 'id' => $model->parent_institution_structure_id], ['target' => 'blank']);
                    },
                    'format' => 'html'
                ],
                [
                    'attribute' => 'institution_type_id',
                    'value' => function ($model) {
                        return $model->getType()->institution_type_name;
                    }
                ],
                [
                    'attribute' => 'is_active',
                    'value' => function ($model) {
                        return DataDefinition::getStyledBooleanTypes()[$model->is_active];
                    },
                    'format' => 'html'
                ],
                'phone',
                'fax',
                'email:email',
                'website',
                'post_office_box',
                'region',
                'country',
            //'logo',
            //'logo2',
            //'created_by',
            //'created_at',
            //'updated_by',
            //'updated_at',
            ],
        ])
        ?>

    </div>
</div>
