<?php
/**
 * @link      http://yii2codes.com/
 * @author    Anil Chaudhari <imanilchaudhari@gmail.com>
 * @copyright Copyright (c) 2017 Yii2 Codes
 * @license   http://yii2codes.com/license/
 */

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $option [] */
/* @var $priority [] */
/* @var $changeFreq [] */
?>
<div id="sitemap-home-option" class="sitemap-default-index-home tab-pane">
    <h4><i class="fa fa-home"></i> <?= Yii::t('sitemap', 'Home Option') ?></h4>
    <div class="form-group">
        <?php $selection = isset($option['home']['priority']) ? $option['home']['priority'] : null ?>
        <?= Html::label(
            Yii::t('sitemap', 'Priority:'),
            'option-option_value-home-priority',
            ['class' => 'form-label']
        ) ?>

        <?= Html::dropDownList(
            'Option[option_value][home][priority]',
            $selection, $priority,
            ['class' => 'form-control']
        ) ?>

    </div>
    <div class="form-group">
        <?php $selection = isset($option['home']['changefreq']) ? $option['home']['changefreq'] : null ?>
        <?= Html::label(
            Yii::t('sitemap', 'Change Frequency:'),
            'option-option_value-home-changefreq',
            ['class' => 'form-label']
        ) ?>

        <?= Html::dropDownList(
            'Option[option_value][home][changefreq]',
            $selection,
            $changeFreq,
            ['class' => 'form-control']
        ) ?>

    </div>
</div>
