<?php

namespace api\modules\v1;

use Yii;
use yii\base\BootstrapInterface;

class Module extends \yii\base\Module implements BootstrapInterface
{
    public function init()
    {
        parent::init();

        // ...  other initialization code ...
    }

    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        $app->getUrlManager()->addRules([
            [
                'class' => 'yii\rest\UrlRule',
                    'controller' => [
                        'v1/user'
                    ],
                    'tokens' => [
                        '{id}' => '<id:\\w+>'
                    ]
            ]
        ], false);
    }
}