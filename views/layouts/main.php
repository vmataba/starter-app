<?php
/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\assets\tools\Tool;

AppAsset::register($this);

if (empty(Yii::$app->session['user'])) {
    Yii::$app->controller->redirect(['site/log-me-out']);
    return;
}
?>
<?php $this->beginPage() ?>
<!doctype html>
<html lang="<?= Yii::$app->language ?>">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
        <!-- GOOGLE FONTS -->
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
        <!-- ICONS -->
        <link rel="apple-touch-icon" sizes="76x76" href="template/klorofil/assets/img/apple-icon.png">
        <link rel="icon" type="image/png" sizes="96x96" href="template/klorofil/assets/img/favicon.png">
        <script src='template/klorofil/assets/vendor/jquery/jquery.min.js'></script>      
        <?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <style>
            .search-box{
                margin-right: 15px;
                background: url("<?= Tool::getSearchIcon() ?>");
                background-size: 30px;
                background-repeat: no-repeat;
                padding-left: 31px
            }
            .icon-reset{
                margin-right: 15px;
                background: url("<?= Tool::getResetIcon() ?>");
                background-size: 30px;
                background-repeat: no-repeat;
            }
            .icon-ms-excel{
                margin-right: 1px;
                background: url("<?= Tool::getExcelIcon() ?>");
                background-size: 17px;
                background-repeat: no-repeat;
                padding-left: 31px
            }
            .icon-pdf{
                margin-right: 1px;
                background: url("<?= Tool::getPdfIcon() ?>");
                background-size: 17px;
                background-repeat: no-repeat;
                padding-left: 31px
            }
            .icon-png{
                margin-right: 1px;
                background: url("<?= Tool::getPngIcon() ?>");
                background-size: 17px;
                background-repeat: no-repeat;
                padding-left: 31px
            }
            .icon-key-pass{
                margin-right: 1px;
                background: url("<?= Tool::getKeyPassIcon() ?>");
                background-size: 20px;
                background-repeat: no-repeat;
                padding-left: 31px
            }
            .round-input{
                border-radius: 10px
            }
        </style>
    </head>

    <body>
        <?php $this->beginBody() ?>
        <div id="wrapper">
            <nav class="navbar navbar-default navbar-fixed-top">
                <?= $this->render('_navbar') ?>
            </nav>
            <div id="sidebar-nav" class="sidebar">
                <div class="sidebar-scroll">
                    <?= $this->render('_sidebar') ?>
                </div>
            </div>
            <div class="main">
                <div class="main-content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6">
                                <h3><?= $this->title ?></h3>
                            </div>
                            <div class="col-sm-6">
                                <?=
                                Breadcrumbs::widget([
                                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                                ])
                                ?>
                            </div>
                        </div>
                        <?= Alert::widget() ?>
                        <?= $content ?>   
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <footer>
                <?php //$this->render('_footer')  ?>
            </footer>
        </div>

        <script>
            $(document).ready(() => {
                styleCheckBoxes();
            });
        </script>

        <script>
            $('.breadcrumb').css('margin-bottom', '0px');
            $('.breadcrumb').css('margin-top', '10px');
            //$('.breadcrumb').css('background-color', '#FFFFFF');
            $('body').css('background-color', '#FFFFFF');
            $('.main').css('background-color', '#FFFFFF');
        </script>
    </body>
    <?php $this->endBody() ?>
</html>
<?php $this->endPage() ?>
