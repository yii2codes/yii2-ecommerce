<?php
/**
 * @link http://yii2codes.com/
 * @copyright Copyright (c) 2016 Yii2 Codes
 * @license http://yii2codes.com/license/
 */

namespace themes\saurs\classes\assets;

use yii\web\AssetBundle;

/**
 * Register asset files for saurs default theme.
 *
 * @author Anil Chaudhari <imanilchaudhari@gmail.com>
 * @since 0.1.0
 */
class ThemeAsset extends AssetBundle
{
    public $sourcePath = '@themes/saurs/assets';
    public $depends = [
        'rmrevin\yii\fontawesome\AssetBundle',
    ];
     public $publishOptions = [
        'forceCopy'=>true,
      ];

    public function init()
    {
        $this->css = ['css/style.css','css/bootstrap.min.css','css/carousel.css'];
        $this->js=['js/holder.min.js','js/viewport.ie.js','js/jquery.min.js','js/bootstrap.min.js'];
    }
}