<?php
/**
 * @link      http://yii2codes.com/
 * @author    Anil Chaudhari <imanilchaudhari@gmail.com>
 * @copyright Copyright (c) 2017 Yii2 Codes
 * @license   http://yii2codes.com/license/
 */

/* @var $this yii\web\View */
/* @var $optionName string */
/* @var $option [] */
/* @var $postTypes backend\models\PostType[] */
/* @var $taxonomies backend\models\Taxonomy[] */

$this->title = Yii::t('sitemap', 'XML Sitemap');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sitemap-default-index">
    <?= $this->render('_form', [
        'option'     => $option,
        'postTypes'  => $postTypes,
        'taxonomies' => $taxonomies,
    ]) ?>
</div>
