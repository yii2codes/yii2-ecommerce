<?php
/**
 * @link http://yii2codes.com/
 * @author Anil Chaudhari <imanilchaudhari@gmail.com>, Saurav Maharjan <saurssaurav33@gmail.com>
 * @copyright Copyright (c) 2016 Yii2 Codes
 * @license http://yii2codes.com/license/
 */

use common\models\Option;
use yii\helpers\Html;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $products common\models\Products[] */
/* @var $pages yii\data\Pagination */

$this->title = Html::encode(Option::get('sitetitle') . ' - ' . Option::get('tagline'));
$this->params['breadcrumbs'][] = Html::encode(Option::get('sitetitle'));
?>
