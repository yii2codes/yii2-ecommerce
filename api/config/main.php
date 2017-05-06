<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/params.php')
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'v1', 'gii'],
    'modules' => [
        'v1' => [
            'basePath' => '@api/modules/v1',
            'class' => 'api\modules\v1\Module'   // here is our v1 modules
        ],
        'gii' => [
            'class' => 'yii\gii\Module',
            'allowedIPs' => ['127.0.0.1', '::1']
        ],
    ],
    'components' => [
        'user' => [
            'identityClass' => 'api\models\User',
            'enableAutoLogin' => false,
            'loginUrl' =>null,
            'enableSession' => false,
        ],
        'request' => [
            'enableCookieValidation' => false,
            'enableCsrfValidation'   => false,
            // Enable JSON Input:
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'jyRmkQPIvRn__kTJhfdfheilfkjdjlf8CPa_',
        ],

        // 'response' => [
        //     'on beforeSend' => function ($event)
        //     {
        //          $response = $event->sender;
        //          //return $response;
        //          $data = $response->data;
        //         if ($response->data !== null && $response->statusCode < 400) {
        //             $response->data = [
        //                     'success' => true,
        //                     'data' => $data,
        //                     'status' => $response->statusCode,
        //                 ];
        //                  // ...customize the response data further here...
        //                 //$response->statusCode = 200;
        //             } else
        //             {
        //                 // show error
        //                 $response->data = [
        //                     'success' => false,
        //                     'error' => $data,
        //                     'status' => $response->statusCode,
        //                 ];
        //             }
        //     }
        // ],

        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false
        ],
    ],
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
    ],
    'as hostControl' => [
        'class' => 'yii\filters\HostControl',
        'allowedHosts' => [
            '192.168.1.100',
            'localhost',
            'example.com',
            '*.example.com',
        ],
        'fallbackHostInfo' => 'https://example.com',
    ],
    'params' => $params,
];