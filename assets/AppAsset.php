<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle {

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'template/klorofil/assets/vendor/bootstrap/css/bootstrap.min.css',
        'template/klorofil/assets/vendor/font-awesome/css/font-awesome.min.css',
        'template/klorofil/assets/vendor/linearicons/style.css',
        'template/klorofil/assets/vendor/chartist/css/chartist-custom.css',
        'template/klorofil/assets/css/main.css',
        'template/klorofil/assets/css/demo.css'
    ];
    public $js = [
        //'template/klorofil/assets/vendor/jquery/jquery.min.js',
        'template/klorofil/assets/vendor/bootstrap/js/bootstrap.min.js',
        'template/klorofil/assets/vendor/jquery-slimscroll/jquery.slimscroll.min.js',
        'template/klorofil/assets/vendor/jquery.easy-pie-chart/jquery.easypiechart.min.js',
        'template/klorofil/assets/vendor/chartist/js/chartist.min.js',
        'template/klorofil/assets/scripts/klorofil-common.js',
        'js/site.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
            //'yii\bootstrap4\BootstrapAsset',
    ];

}
