<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use app\assets\DataDefinition;
use app\assets\tools\Tool;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\IdentityTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Identity Types';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="identity-type-index">

    <p>
        <?= Html::a('Add New Type', '#', ['class' => 'btn btn-success btn-sm', 'id' => 'btnNewType', 'data-toggle' => 'modal', 'data-target' => '#modalNewIdType']) ?>
    </p>

    <!-- Modal -->
    <div class="modal fade" id="modalNewIdType" tabindex="-1" role="dialog" aria-labelledby="modalNewIdTypeTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">New Identity Type</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php $form = ActiveForm::begin(); ?>

                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'code', ['enableAjaxValidation' => true])->textInput(['maxlength' => true, 'id' => 'code']) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'name')->textInput(['id' => 'name']) ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <?= $form->field($model, 'is_active')->checkbox(['id' => 'is_active']) ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="btn_save">Save changes</button>
                    <button type="submit" class="btn btn-primary" id="btn_update" style="display: none">Update changes</button>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'id',
            [
                'attribute' => 'code',
                'filterInputOptions' => [
                    'placeholder' => 'Search...',
                    'class' => 'form-control'
                ]
            ],
            [
                'attribute' => 'name',
                'filterInputOptions' => [
                    'placeholder' => 'Search...',
                    'class' => 'form-control'
                ]
            ],
            [
                'attribute' => 'is_active',
                'value' => function ($model) {
                    return DataDefinition::getStyledBooleanTypes()[$model->is_active];
                },
                'format' => 'html',
                'filter' => DataDefinition::getBooleanTypes(),
                'filterInputOptions' => [
                    'prompt' => 'Select...',
                    'class' => 'form-control'
                ]
            ],
            [
                'attribute' => 'created_at',
                'value' => function ($model) {
                    return Tool::getElapsedTime($model->created_at, true);
                },
                'filter' => false
            ],
            //'created_by',
            //'updated_at',
            //'updated_by',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{delete}',
                'buttons' => [
                    // Customizing a DELETE grid button
                    'delete' => function($url, $model, $key) {
                        return Html::a('<i class="glyphicon glyphicon-trash"></i>', ['delete', 'id' => $model->id], ['class' => '', 'title' => $model->id]);
                    },
                    'update' => function($url, $model, $key) {
                        return Html::a('<i class="glyphicon glyphicon-pencil"></i>', '#', ['class' => '', 'title' => $model->id, 'onclick' => "update($model->id)"]);
                    }
                ]
            ],
        ],
    ]);
    ?>

    <script>

        function update(id) {
            const url = `<?= Url::to(['find-model']) ?>&id=${id}`;
            $.ajax({
                url,
                success: (response) => {
                    const model = JSON.parse(response);

                    $('#btn_save').css('display', 'none');
                    $('#btn_update').css('display', 'inline');

                    $('#name').val(model.name);
                    $('#code').val(model.code);
                    if (parseInt(model.is_active) === 1) {
                        $('#is_active').prop("checked", true);
                    }
                    $('#modalNewIdType').modal('show');

                    $('#btn_update').click(() => {

                        const updateUrl = `<?= Url::to(['update']) ?>&id=${id}`;
                        $.ajax({
                            url: updateUrl,
                            type: 'post',
                            data: {
                                name: $('#name').val(),
                                code: $('#code').val(),
                                is_active: ($('#is_active').propt('checked', true) ? 1 : 0)
                            },
                            success: (response) => {
                                // console.log(response);
                            }
                        });

                    });
                }
            });
        }

    </script>
