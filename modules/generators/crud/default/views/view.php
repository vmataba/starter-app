<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

$this->title = $model-><?= $generator->getNameAttribute() ?>;
$this->params['breadcrumbs'][] = ['label' => <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-view">

    <p>
        <?= "<?= " ?>Html::a(<?= '"'."<i class='glyphicon glyphicon-pencil'></i>".'"' ?>, ['update', <?= $urlParams ?>], ['class' => 'btn btn-sm','title' => 'Update']) ?>
        <?= "<?php " ?>Html::a(<?= $generator->generateString("<i class='glyphicon glyphicon-trash text-danger'></i>") ?>, ['delete', <?= $urlParams ?>], [
        'class' => 'btn btn-sm',
        'data' => [
        'confirm' => <?= $generator->generateString('Are you sure you want to delete this item?') ?>,
        'method' => 'post',
        ],
        ]) ?>
    </p>


    <div class="panel">
        <div class="panel-body">
            <table class="table">
                <?php
                if (($tableSchema = $generator->getTableSchema()) === false) {
                    foreach ($generator->getColumnNames() as $name) {
                        echo "            '" . $name . "',\n";
                    }
                } else {
                    $count = 1;
                    foreach ($generator->getTableSchema()->columns as $column) {
                        echo "<tr>\n";
                        if ($count === 1) {
                            echo "<th style='border-top: none'>";
                        } else {
                            echo "<th>";
                        }
                        $format = $generator->generateColumnFormat($column);
                        echo ucfirst(str_replace("_", " ", $column->name));
                        echo "</th>\n";

                        if ($count === 1) {
                            echo "<td style='border-top: none'>";
                        } else {
                            echo "<td>";
                        }

                        echo "<?=$" . "model->" . $column->name;
                        echo "?></td>\n";
                        echo "</tr>\n";
                        $count++;
                    }
                }
                ?>

            </table>
        </div>
    </div>    


</div>
