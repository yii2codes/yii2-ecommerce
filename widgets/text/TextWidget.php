<?php
/**
* @link https://yii2codes.com/
* @copyright Copyright (c) 2017 Yii2 Codes
* @license https://yii2codes.com/license/
*/

namespace widgets\text;

use yii\helpers\Html;
use common\components\BaseWidget;

class TextWidget extends BaseWidget
{
    /**
     * @var string
     */
    public $text = '';

    /**
     * @inheritdoc
     */
    public function run()
    {
        echo $this->beforeWidget;

        if ($this->title) {
            echo $this->beforeTitle . $this->title . $this->afterTitle;
        }

        echo Html::tag('div', $this->text, [
            'class' => 'widget-text',
        ]);
        echo $this->afterWidget;
    }
}
