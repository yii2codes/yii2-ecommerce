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
<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd"
        xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <?php foreach ($items as $item): ?>
        <url>
            <loc><![CDATA[<?= $item['loc'] ?>]]></loc>
            <lastmod><?= $item['lastmod'] ?></lastmod>
            <changefreq><?= $item['changefreq'] ?></changefreq>
            <priority><?= $item['priority'] ?></priority>
        </url>
    <?php endforeach ?>
</urlset>
