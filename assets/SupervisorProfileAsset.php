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
class SupervisorProfileAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/profile.css',
    ];
    public $js = [
        'js/supervisor-profile.js',
    ];
    public $depends = [
        'app\assets\BootstrapDatepickerAsset',
        'app\assets\AppAsset',
    ];
}
