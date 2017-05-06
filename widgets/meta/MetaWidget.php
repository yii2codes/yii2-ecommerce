<?php
/**
* @link https://yii2codes.com/
* @copyright Copyright (c) 2017 Yii2 Codes
* @license https://yii2codes.com/license/
*/

namespace widgets\meta;

use Yii;
use yii\widgets\Menu;
use common\components\BaseWidget;


class MetaWidget extends BaseWidget
{
    /**
     * @inheritdoc
     */
    public function run()
    {
        echo $this->beforeWidget;

        if ($this->title) {
            echo $this->beforeTitle . $this->title . $this->afterTitle;
        }

        echo Menu::widget([
            'items' => [
                [
                    'label' => 'Site Admin',
                    'url' => Yii::$app->urlManagerBack->baseUrl,
                    'visible' => !Yii::$app->user->isGuest,
                ],
                [
                    'label' => 'Login',
                    'url' => Yii::$app->urlManagerBack->createUrl(['/site/login']),
                    'visible' => Yii::$app->user->isGuest,
                ],
                [
                    'label' => 'Logout',
                    'url' => Yii::$app->urlManager->createUrl(['/site/logout']),
                    'visible' => !Yii::$app->user->isGuest,
                    'template' => '<a href="{url}" data-method="post">{label}</a>',
                ],
                [
                    'label' => 'Yii2 Codes',
                    'url' => 'https://yii2codes.com/',
                ],
            ],
        ]);
        echo $this->afterWidget;
    }
}