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
/* @var $postTypes backend\models\PostType[] */
?>
<div id="sitemap-service-option" class="sitemap-default-index-service tab-pane">

        <h4><i class="fa fa-safari"></i> Services</h4>
        <div class="form-group checkbox">
            <?= Html::hiddenInput("Option[option_value][service][enable]", 0) ?>

            <label>
                <?php $checked = isset($option['service']['enable'])
                && $option['service']['enable']
                    ? true
                    : false;
                ?>
                <?= Html::checkbox(
                    "Option[option_value][service][enable]",
                    $checked,
                    ['value' => 1]
                ) ?>

                <?= Yii::t('sitemap', 'Please check this checkbox if you want to include in your sitemap.') ?>

            </label>
        </div>

        <div class="form-group">
            <?php
            $selection = isset($option['service']['priority'])
            && $option['service']['priority']
                ? $option['service']['priority']
                : null;
            ?>
            <?= Html::label(
                Yii::t('sitemap', 'Priority:'),
                'option-option_value-service-priority',
                ['class' => 'form-label']
            ) ?>

            <?= Html::dropDownList(
                "Option[option_value][service][priority]",
                $selection, $priority, [
                    'class' => 'form-control',
                    'id'    => 'option-option_value-service-priority',
                ]
            ) ?>

        </div>
        <div class="form-group">
            <?php
            $selection = isset($option['service']['changefreq'])
            && $option['service']['changefreq']
                ? $option['service']['changefreq']
                : null;
            ?>
            <?= Html::label(
                Yii::t('sitemap', 'Change Frequency:'),
                'option-option_value-service-changefreq',
                ['class' => 'form-label']
            ) ?>

            <?= Html::dropDownList(
                "Option[option_value][service][changefreq]",
                $selection,
                $changeFreq, [
                    'class' => 'form-control',
                    'id'    => 'option-option_value-service-changefreq',
                ]
            ) ?>

        </div>

</div>
