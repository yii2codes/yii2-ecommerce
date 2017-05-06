<?php
/**
 * @link      http://yii2codes.com/
 * @copyright Copyright (c) 2017 Yii2 Codes
 * @license   http://yii2codes.com/license/
 */

namespace modules\feed\frontend\controllers;

use frontend\models\Option;
use frontend\models\Post;
use Yii;
use yii\web\Controller;

/**
 * Class DefaultController
 *
 * @author  Anil Chaudhari <imanilchaudhari@gmail.com>
 * @since   0.2.0
 */
class DefaultController extends Controller
{
    /**
     * Displaying feed.
     *
     * @return string
     */
    public function actionIndex()
    {
        /* @var $lastPost \frontend\models\Post */
        $response = Yii::$app->response;
        $response->headers->set('Content-Type', 'text/xml; charset=UTF-8');
        $response->format = $response::FORMAT_RAW;

        // Get first post and all posts
        $lastPost = Post::find()
            ->where(['status' => Post::STATUS_PUBLISH])
            ->andWhere(['<=', 'created_at', time()])
            ->orderBy(['id' => SORT_DESC])->one();

        $posts = Post::find()
            ->where(['status' => Post::STATUS_PUBLISH])
            ->andWhere(['<=', 'created_at', time()])
            ->limit(Option::get('posts_per_rss'))
            ->orderBy(['id' => SORT_DESC])
            ->all();

        return $this->renderPartial('index', [
            'title'         => Option::get('sitetitle'),
            'description'   => Option::get('tagline'),
            'link'          => Yii::$app->request->absoluteUrl,
            'lastBuildDate' => new \DateTime(date('Y-m-d H:i:s', $lastPost->created_at), new \DateTimeZone(Option::get('time_zone'))),
            'language'      => Yii::$app->language,
            'generator'     => 'http://www.computingcastle.com',
            'posts'         => $posts,
            'rssUseExcerpt' => Option::get('rss_use_excerpt'),
        ]);
    }
}
