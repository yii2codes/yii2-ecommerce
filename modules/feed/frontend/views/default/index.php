<?php
/**
 * @link      http://yii2codes.com/
 * @author    Anil Chaudhari <imanilchaudhari@gmail.com>
 * @copyright Copyright (c) 2017 Yii2 Codes
 * @license   http://yii2codes.com/license/
 */

use frontend\models\Option;

/* @var $title string */
/* @var $link string */
/* @var $description */
/* @var $lastBuildDate \DateTime */
/* @var $language string */
/* @var $generator string */
/* @var $postTypes frontend\models\PostType[] */
/* @var $posts frontend\models\Post[] */

?>
<?= '<?xml version="1.0" encoding="UTF-8"?>' ?>
<rss version="2.0" xmlns:content="http://purl.org/rss/1.0/modules/content/"
     xmlns:wfw="http://wellformedweb.org/CommentAPI/" xmlns:dc="http://purl.org/dc/elements/1.1/"
     xmlns:atom="http://www.w3.org/2005/Atom" xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
     xmlns:slash="http://purl.org/rss/1.0/modules/slash/">
    <channel>
        <title><?= $title ?></title>
        <atom:link href="<?= $link ?>" rel="self" type="application/rss+xml"/>
        <link><?= $link ?></link>
        <description><![CDATA[<?= $description ?>]]></description>
        <lastBuildDate><?= $lastBuildDate->format('r') ?></lastBuildDate>
        <language><?= Yii::$app->language ?></language>
        <sy:updatePeriod>hourly</sy:updatePeriod>
        <sy:updateFrequency>1</sy:updateFrequency>
        <generator><?= $generator ?></generator>
        <?php foreach ($posts as $post): ?>
            <item>
                <title><?= $post->title ?></title>
                <link>
                <![CDATA[<?= $post->getUrl() ?>]]></link>
                <comments><![CDATA[<?= $post->getUrl() ?>#comments]]></comments>
                <pubDate>
                    <?php
                    $postDate = new DateTime(date('Y-m-d H:i:s', $post->created_at), new DateTimeZone(Option::get('time_zone')));
                    echo $postDate->format('r');
                    ?>
                </pubDate>
                <dc:creator><![CDATA[<?= $post->postAuthor->display_name ?>]]></dc:creator>
                <?php foreach ($post->terms as $term): ?>
                    <category><![CDATA[<?= $term->name ?>]]></category>
                <?php endforeach ?>
                <guid isPermaLink="false">
                    <![CDATA[<?= Yii::$app->urlManager->createAbsoluteUrl(['post/view', 'id' => $post->id]) ?>]]>
                </guid>
                <description><![CDATA[<?= $post->excerpt ?>]]></description>
                <?php if (!Option::get('rss_use_excerpt')): ?>
                    <content:encoded><![CDATA[<?= $post->content ?>]]></content:encoded>
                <?php endif ?>
                <wfw:commentRss><![CDATA[<?= $post->slug ?>]]></wfw:commentRss>
                <slash:comments><?= $post->comment_count ?></slash:comments>
            </item>
        <?php endforeach ?>
    </channel>
</rss>
