<?php
/**
 * @link http://yii2codes.com/
 * @author Anil Chaudhari <imanilchaudhari@gmail.com>, Saurav Maharjan <saurssaurav33@gmail.com>
 * @copyright Copyright (c) 2016 Yii2 Codes
 * @license http://yii2codes.com/license/
 */

namespace themes\saurs\classes\widgets;

use Yii;

/**
 * Class Nav
 *
 * @author Anil Chaudhari <imanilchaudhari@gmail.com>, Saurav Maharjan <saurssaurav33@gmail.com>
 * @since 0.1.0
 */
class Nav extends \frontend\widgets\Nav
{
    public $options = [];
    /**
     * @inheritdoc
     */
    protected function isItemActive($item)
    {
        if (isset($item['url']) && $item['url'] === Yii::$app->request->absoluteUrl) {
            return true;
        }

        return false;
    }
}