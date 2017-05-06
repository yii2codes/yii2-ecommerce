<?php
/**
 * @link      http://yii2codes.com/
 * @author    Anil Chaudhari <imanilchaudhari@gmail.com>
 * @copyright Copyright (c) 2017 Yii2 Codes
 * @license   http://yii2codes.com/license/
 */

use yii\helpers\Url;

/* @var $items array */
?>
<?= '<?xml version="1.0" encoding="UTF-8"?>' ?>
<?= '<?xml-stylesheet type="text/xsl" href="' . Url::to(['style']) . '"?>' ?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <sitemap>
        <loc><![CDATA[<?= Yii::$app->urlManager->hostInfo
            . Url::to(['view', 'type' => 'h', 'slug' => 'home', 'page' => 1]) ?>]]>
        </loc>
        <lastmod>
            <?php
            $lastmod = new \DateTime('now', new \DateTimeZone(Yii::$app->timeZone));
            echo $lastmod->format('r')
            ?>
        </lastmod>
    </sitemap>
    <?php foreach ($items as $item): ?>
        <?= '<sitemap>' ?>
        <?= '<loc><![CDATA[' . $item['loc'] . ']]></loc>' ?>
        <?= '<lastmod>' . $item['lastmod'] . '</lastmod>' ?>
        <?= '</sitemap>' ?>
    <?php endforeach ?>
</sitemapindex>
