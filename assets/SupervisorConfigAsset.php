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
class SupervisorConfigAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/vendor/bootstrap-timepicker.css',
        'css/vendor/bootstrap-timepicker.min.css',
        'css/vendor/bootstrap-toggle.min.css',
    ];
    public $js = [
        'js/vendor/bootstrap-timepicker.js',
        'js/vendor/bootstrap-timepicker.min.js',
        'js/vendor/bootstrap-toggle.min.js',
        'js/supervisor/configForm.js',
    ];
    public $depends = [
        'app\assets\AppAsset',
    ];
}
