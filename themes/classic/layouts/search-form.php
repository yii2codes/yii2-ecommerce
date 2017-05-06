<?php
/**
 * @link http://yii2codes.com/
 * @author Anil Chaudhari <imanilchaudhari@gmail.com>, Saurav Maharjan <saurssaurav33@gmail.com>
 * @copyright Copyright (c) 2016 Yii2 Codes
 * @license http://yii2codes.com/license/
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

?>
<?php $form = ActiveForm::begin([
    'action' => Url::to(['/site/search']),
    'method' => 'get',
    'options' => ['class' => 'form-search'],
]) ?>

<div class="input-group">
    <?= Html::textInput('s', null, ['class' => 'form-control', 'placeholder' => 'Search...']) ?>

    <span class="input-group-btn">
        <?= Html::submitButton(
            '<span class="glyphicon glyphicon-search"></span>',
            ['class' => ' btn btn-default']
        ) ?>

    </span>
</div>
<?php ActiveForm::end() ?>