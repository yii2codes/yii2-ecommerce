<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $widget common\models\Widget */

?>
<?php $config = $widget->getConfig() ?>
<?= Html::hiddenInput('Widget[config][class]', $config['class']) ?>

<div class="form-group">
    <?= Html::label('Title', 'title-' . $widget->id, ['class' => 'form-label']) ?>

    <?= Html::textInput(
        'Widget[config][title]',
        $config['title'],
        ['class' => 'form-control input-sm']
    ) ?>

</div>
<div class="form-group">
    <?= Html::label('Title', 'text-' . $widget->id, ['class' => 'form-label']) ?>
    dskjeu

     

    <?= Html::textarea('Widget[config][text]', $config['text'], [
        'id' => 'text-' . $widget->id,
        'class' => 'form-control',
        'rows' => '5',
    ]) ?>

    <?= Html::label('Size', 'text-' . $widget->id, ['class' => 'form-label']) ?>

    <?= Html::textInput('Widget[config][size]', $config['size'], [
        'id' => 'text-' . $widget->id,
        'class' => 'form-control',
        'rows' => '5',
    ]) ?>

</div>
