<?php
/**
 * @link http://yii2codes.com/
 * @author Anil Chaudhari <imanilchaudhari@gmail.com>, Saurav Maharjan <saurssaurav33@gmail.com>
 * @copyright Copyright (c) 2016 Yii2 Codes
 * @license http://yii2codes.com/license/
 */

use frontend\widgets\RenderWidget;

/* @var $this yii\web\View */
/* @var $taxonomies common\models\Taxonomy[] */
?>
<div class="col-md-4">
    <div id="sidebar">
        <?= RenderWidget::widget([
            'location' => 'sidebar',
            'config' => [
                'beforeWidget' => '<div class="widget">',
                'afterWidget' => '</div>',
                'beforeTitle' => '<div class="widget-title"> <h4>',
                'afterTitle' => '</div></h4>',
            ],
        ]) ?>
    </div>
</div>