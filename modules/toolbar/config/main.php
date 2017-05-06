<?php
/**
 * @link      http://yii2codes.com/
 * @author    Anil Chaudhari <imanilchaudhari@gmail.com>
 * @copyright Copyright (c) 2017 Yii2 Codes
 * @license   http://yii2codes.com/license/
 */

return [
    'name' => 'toolbar',
    'title' => 'Toolbar',
    'config' => [
        'frontend' => [
            'class' => 'modules\toolbar\frontend\Module',
        ],
    ],
    'frontend_bootstrap' => 1,
];
