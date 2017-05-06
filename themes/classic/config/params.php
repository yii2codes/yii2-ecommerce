<?php
/**
 * @link http://yii2codes.com/
 * @author Anil Chaudhari <imanilchaudhari@gmail.com>, Saurav Maharjan <saurssaurav33@gmail.com>
 * @copyright Copyright (c) 2016 Yii2 Codes
 * @license http://yii2codes.com/license/
 */

return [
    'backend' => [
        'menu' => [
            'location' => [
                'primary' => 'Primary',
            ],
        ],
        'postType' => [
            'post' => [
                'meta' => [
                    ['class' => 'themes\classic\classes\meta\Meta'],
                ],
                'support' => [],
            ],
            'page' => [
                'meta' => [
                    ['class' => 'themes\classic\classes\meta\Meta'],
                ],
                'support' => [],
            ],
        ],
        'widget' => [
            [
                'title' => 'Sidebar',
                'description' => 'Main sidebar that appears on the right.',
                'location' => 'sidebar',
            ],
            [
                'title' => 'Footer Left',
                'description' => 'Appears on the left of footer',
                'location' => 'footer-left',
            ],
            [
                'title' => 'Footer Middle',
                'description' => 'Appears on the middle of footer',
                'location' => 'footer-middle',
            ],
            [
                'title' => 'Footer Right',
                'description' => 'Appears on the right of footer',
                'location' => 'footer-right',
            ],
        ],
    ],
];