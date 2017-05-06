<?php
/**
 * @link http://yii2codes.com/
 * @author Anil Chaudhari <imanilchaudhari@gmail.com>, Saurav Maharjan <saurssaurav33@gmail.com>
 * @copyright Copyright (c) 2016 Yii2 Codes
 * @license http://yii2codes.com/license/
 */

use common\models\Option;
use themes\classic\classes\assets\ThemeAsset;
use yii\helpers\Html;

$assetBundle = ThemeAsset::register($this);

/* @var $this \yii\web\View */
/* @var $content string */

// Canonical
$this->registerLinkTag(['rel' => 'canonical', 'href' => Yii::$app->request->absoluteUrl]);

// Favicon
$this->registerLinkTag([
    'rel' => 'icon',
    'href' => $assetBundle->baseUrl . '/img/favicon.ico',
    'type' => 'image/x-icon',
]);
// Add meta robots noindex, nofollow when option disable_site_indexing = true
if (Option::get('disable_site_indexing')) {
    $this->registerMetaTag(['name' => 'robots', 'content' => 'noindex, nofollow']);
}
// Get site-title and tag-line
$siteTitle = Option::get('sitetitle');
$tagLine = Option::get('tagline');
$this->beginPage();
?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://fonts.googleapis.com/css?family=Doppio+One|Jaldi" rel="stylesheet">
    <?= Html::csrfMetaTags() ?>
    <title>
        <?= $this->title ?>
    </title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<?= $this->render('header', [
    'assetBundle' => $assetBundle,
    'siteTitle' => $siteTitle,
    'tagLine' => $tagLine,
]) ?>

<?= $content ?>

<?= $this->render('footer') ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>