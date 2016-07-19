<?php

namespace worstinme\forum\assets;

use yii\web\AssetBundle;

class Asset extends AssetBundle
{
    public $sourcePath = '@worstinme/forum/assets';

    public $css = [
        'css'=>'css/forum.css',
    ];

    public $js = [
        
    ];

    public $depends = [
        'worstinme\uikit\UikitAsset',
    ];

    public $publishOptions = [
        'forceCopy'=> YII_ENV_DEV ? true : false,
    ];
}