<?php
/**
 * @link http://yii2codes.com/
 * @copyright Copyright (c) 2016 Yii2 Codes
 * @license http://yii2codes.com/license/
 */

namespace themes\saurs\classes\meta;

use Yii;
use yii\base\Object;

/**
 * Class MetaBox
 *
 * @author Anil Chaudhari <imanilchaudhari@gmail.com>, Saurav Maharjan <saurssaurav33@gmail.com>
 * @since 0.1.0
 */
class Meta extends Object
{
    /**
     * @var \common\models\Post
     */
    public $model;

    /**
     * @var \yii\widgets\ActiveForm
     */
    public $form;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->renderBox();
    }

    public function renderBox()
    {
        echo Yii::$app->view->renderFile(__DIR__ . '/views/_form.php', [
            'model' => $this->model,
            'form'  => $this->form
        ]);
    }
}