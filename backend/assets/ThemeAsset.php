<?php

namespace backend\assets;

use yiister\gentelella\assets\Asset;

class ThemeAsset extends Asset
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        /*code here*/
    ];
    public $js = [
        /*code here*/
    ];

    public $depends = [
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'yiister\gentelella\assets\ThemeAsset',
        'yiister\gentelella\assets\ExtensionAsset',
    ];
}