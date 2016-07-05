<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/intern-portal.css',
        'css/bootstrap.vertical-tabs.min.css'
    ];
    public $js = [
        'js/vendor/handlebars.min-v4.0.2.js',
        'js/intern-portal.js',
        'js/vendor/spin.min.js',
        'js/vendor/jquery.spin.js',
        'js/vendor/js.cookie.js',
        'js/vendor/moment.min.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
