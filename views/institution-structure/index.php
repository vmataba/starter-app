<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\InstitutionType;
use app\models\InstitutionStructure;
use app\assets\DataDefinition;

/* @var $this yii\web\View */
/* @var $searchModel app\models\InstitutionStructureSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Institution Structures';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="institution-structure-index">

    <p>
        <?= Html::a('Add New Structure', ['create'], ['class' => 'btn btn-success btn-sm']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'id',
            [
                'attribute' => 'institution_name',
                'filterInputOptions' => [
                    'placeholder' => 'Search...',
                    'class' => 'form-control'
                ]
            ],
            [
                'attribute' => 'institution_acronym',
                'filterInputOptions' => [
                    'placeholder' => 'Search...',
                    'class' => 'form-control'
                ]
            ],
            [
                'attribute' => 'code',
                'filterInputOptions' => [
                    'placeholder' => 'Search...',
                    'class' => 'form-control'
                ]
            ],
            [
                'attribute' => 'parent_institution_structure_id',
                'value' => function ($model) {
                    if (!$model->hasParent()) {
                        return "<center><b>--ROOT--</b></center>";
                    }
                    return Html::a($model->getParent()->institution_name, ['view', 'id' => $model->parent_institution_structure_id], ['target' => 'blank']);
                },
                'format' => 'html',
                'filter' => InstitutionStructure::getParents(),
                'filterInputOptions' => [
                    'prompt' => 'Select...',
                    'class' => 'form-control'
                ]
            ],
            [
                'attribute' => 'institution_type_id',
                'value' => function ($model) {
                    return $model->getType()->institution_type_name;
                },
                'filter' => InstitutionType::getTypes(),
                'filterInputOptions' => [
                    'prompt' => 'Select...',
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
            //'phone',
            //'fax',
            //'email:email',
            //'website',
            //'post_office_box',
            //'region',
            //'country',
            //'logo',
            //'logo2',
            //'created_by',
            //'created_at',
            //'updated_by',
            //'updated_at',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}{update}'
            ],
        ],
    ]);
    ?>



</div>
