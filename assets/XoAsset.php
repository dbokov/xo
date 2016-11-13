<?php
/**
 * Created by PhpStorm.
 * User: wh1sper
 * Date: 12.11.16
 * Time: 23:11
 */

namespace dbokov\xo\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class XoAsset extends AssetBundle
{
    public $sourcePath = '@vendor/dbokov/xo/assets';

    public $publishOptions = [
        'forceCopy' => true,
    ];

    public $css = [
        'css/xo.css',
    ];

    public $js = [
        'js/xo.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
