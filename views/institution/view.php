<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Institution */

$this->title = $model->institution_name;
$this->params['breadcrumbs'][] = ['label' => 'Institutions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="institution-view">

    <p>
        <?= Html::a("<i class='glyphicon glyphicon-pencil'></i>", ['update', 'id' => $model->id], ['title' => 'Update Details']) ?>
    </p>


    <div class="panel">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    <img src="<?= $model->logo ?>" style="width: <?= $model->logo_width ?>; height:<?= $model->logo_height ?>"/> 
                </div>
                <div class="col-md-12">
                    <table class="table">
                        <tr>
                            <th>Institution code</th>
                            <td><?= $model->institution_code ?></td>
                        </tr>
                        <tr>
                            <th>Subsp code</th>
                            <td><?= $model->subsp_code ?></td>
                        </tr>
                        <tr>
                            <th>Institution name</th>
                            <td><?= $model->institution_name ?></td>
                        </tr>
                        <tr>
                            <th>Logo height</th>
                            <td><?= $model->logo_height ?></td>
                        </tr>
                        <tr>
                            <th>Logo width</th>
                            <td><?= $model->logo_width ?></td>
                        </tr>
                        <tr>
                            <th>Contact details</th>
                            <td><?= $model->contact_details ?></td>
                        </tr>
                        <tr>
                            <th>Home page</th>
                            <td><?= $model->home_page ?></td>
                        </tr>
                    </table>
                </div>
            </div>

        </div>
    </div>    


</div>
