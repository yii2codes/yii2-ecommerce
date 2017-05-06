<?php
/**
 * @link      http://yii2codes.com/
 * @author    Anil Chaudhari <imanilchaudhari@gmail.com>
 * @copyright Copyright (c) 2017 Yii2 Codes
 * @license   http://yii2codes.com/license/
 */

return [
    'name' => 'sitemap',
    'title' => 'Sitemap',
    'description' => 'Module for sitemap',
    'config' => [
        'backend' => [
            'class' => 'modules\sitemap\backend\Module',
        ],
        'frontend' => [
            'class' => 'modules\sitemap\frontend\Module',
        ],
    ],
    'frontend_bootstrap' => 1,
];
