<?php
/**
 * @link      http://yii2codes.com/
 * @copyright Copyright (c) 2017 Yii2 Codes
 * @license   http://yii2codes.com/license/
 */

namespace modules\sitemap\frontend\controllers;


use Yii;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\Controller;

use frontend\models\Media;
use frontend\models\Option;
use frontend\models\Post;
use frontend\models\PostType;
use frontend\models\Taxonomy;
use frontend\models\Term;
use frontend\models\Service;


/**
 * Class DefaultController
 *
 * @author  Anil Chaudhari <imanilchaudhari@gmail.com>
 * @since   0.2.0
 */
class DefaultController extends Controller
{
    /**
     * @var array option for sitemap
     */
    private $_option = [];

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions'       => ['index', 'style', 'view'],
                        'allow'         => true,
                        'matchCallback' => function () {
                            $option = Option::get('sitemap');

                            return $option['enable_sitemap'];
                        },
                    ],
                ],
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        /* @var $postType PostType */
        /* @var $post Post */
        /* @var $taxonomies Taxonomy[] */
        /* @var $taxonomy Taxonomy */
        /* @var $lastMedia Media */

        $response = Yii::$app->response;
        $response->headers->set('Content-Type', 'text/xml; charset=UTF-8');
        $response->format = $response::FORMAT_RAW;
        $postTypes = PostType::find()->select(['id', 'slug'])->all();
        $taxonomies = Taxonomy::find()->select(['id', 'slug'])->all();
        $items = [];

        foreach ($postTypes as $postType) {
            if (isset($this->_option['post_type'][$postType->id]['enable'])
                && $this->_option['post_type'][$postType->id]['enable']
            ) {
                if ($post = $postType->getPosts()
                    ->andWhere(['status' => Post::STATUS_PUBLISH])
                    ->andWhere(['<=', 'created_at', time()])
                    ->orderBy(['id' => SORT_DESC])
                    ->one()
                ) {
                    $lastmod = new \DateTime(date('Y-m-d H:i:s',$post->updated_at), new \DateTimeZone(Option::get('time_zone')));
                    $query = $postType->getPosts()
                        ->andWhere(['status' => Post::STATUS_PUBLISH])
                        ->andWhere(['<=', 'created_at', time()]);
                    $countQuery = clone $query;
                    $pages = new Pagination([
                        'totalCount' => $countQuery->count(),
                        'pageSize'   => $this->_option['entries_per_page'],
                    ]);
                    for ($i = 1; $i <= $pages->pageCount; $i++) {
                        $items[] = [
                            'loc'     => Yii::$app->urlManager->hostInfo
                                . Url::to(['view', 'type' => 'p', 'slug' => $postType->slug, 'page' => $i]),
                            'lastmod' => $lastmod->format('r'),
                        ];
                    }
                }
            }
        }

        foreach ($taxonomies as $taxonomy) {
            if (isset($this->_option['taxonomy'][$taxonomy->id]['enable'])
                && $this->_option['taxonomy'][$taxonomy->id]['enable']
            ) {
                if ($terms = $taxonomy->terms) {
                    $post = Post::find()
                        ->from(['post' => Post::tableName()])
                        ->innerJoinWith([
                            'terms' => function ($query) {
                                /* @var $query \yii\db\ActiveQuery */
                                $query->from(['term' => Term::tableName()]);
                            },
                        ])
                        ->where(['IN', 'term.id', ArrayHelper::getColumn($terms, 'id')])
                        ->andWhere(['post.status' => Post::STATUS_PUBLISH])
                        ->andWhere(['<=', 'created_at', time()])
                        ->orderBy(['post.id' => SORT_DESC])
                        ->one();

                    if ($post) {
                        $query = $taxonomy->getTerms();
                        $lastmod = new \DateTime(date('Y-m-d H:i:s',$post->updated_at), new \DateTimeZone(Option::get('time_zone')));
                        $countQuery = clone $query;
                        $pages = new Pagination([
                            'totalCount' => $countQuery->count(),
                            'pageSize'   => $this->_option['entries_per_page'],
                        ]);

                        for ($i = 1; $i <= $pages->pageCount; $i++) {
                            $items[] = [
                                'loc'     => Yii::$app->urlManager->hostInfo
                                    . Url::to(['view', 'type' => 'c', 'slug' => $taxonomy->slug, 'page' => $i]),
                                'lastmod' => $lastmod->format('r'),
                            ];
                        }
                    }
                }
            }
        }

        if (isset($this->_option['media']['enable']) && $this->_option['media']['enable']) {
            $query = Media::find();
            $countQuery = clone $query;
            $pages = new Pagination([
                'totalCount' => $countQuery->count(),
                'pageSize'   => $this->_option['entries_per_page'],
            ]);

            if ($lastMedia = $query->orderBy(['id' => SORT_DESC])->one()) {
                $lastmod = new \DateTime(date('Y-m-d H:i:s',$lastMedia->updated_at), new \DateTimeZone(Option::get('time_zone')));
                for ($i = 1; $i <= $pages->pageCount; $i++) {
                    $items[] = [
                        'loc'     => Yii::$app->urlManager->hostInfo
                            . Url::to(['view', 'type' => 'm', 'slug' => 'media', 'page' => $i]),
                        'lastmod' => $lastmod->format('r'),
                    ];
                }
            }
        }

        if (isset($this->_option['service']['enable']) && $this->_option['service']['enable']) {
            $query = Service::find();
            $countQuery = clone $query;
            $pages = new Pagination([
                'totalCount' => $countQuery->count(),
                'pageSize'   => $this->_option['entries_per_page'],
            ]);

            if ($lastService = $query->orderBy(['id' => SORT_DESC])->one()) {
                $lastmod = new \DateTime(date('Y-m-d H:i:s',$lastService->updated_at), new \DateTimeZone(Option::get('time_zone')));
                for ($i = 1; $i <= $pages->pageCount; $i++) {
                    $items[] = [
                        'loc'     => Yii::$app->urlManager->hostInfo
                            . Url::to(['view', 'type' => 's', 'slug' => 'service', 'page' => $i]),
                        'lastmod' => $lastmod->format('r'),
                    ];
                }
            }
        }

        return $this->renderPartial('index', ['items' => $items]);
    }

    /**
     * @return string
     */
    public function actionStyle()
    {
        $response = Yii::$app->response;
        $response->headers->set('Content-Type', 'text/xml; charset=UTF-8');
        $response->format = $response::FORMAT_RAW;

        return $this->renderPartial('style');
    }

    /**
     * @param string $type
     * @param string $slug
     * @param int    $page
     *
     * @return string
     */
    public function actionView($type, $slug, $page = 1)
    {
        /* @var $taxonomy Taxonomy */
        /* @var $postType PostType */
        /* @var $posts Post[] */
        /* @var $images Media[] */
        /* @var $terms Term[] */
        /* @var $mediaSet Media[] */
        /* @var $post Post */

        $page--;
        $items = [];
        $response = Yii::$app->response;
        $response->headers->set('Content-Type', 'text/xml; charset=UTF-8');
        $response->format = $response::FORMAT_RAW;
        if ($type === 'h') {
            $item['loc'] = Yii::$app->urlManager->hostInfo . Yii::$app->urlManager->baseUrl . '/';
            $item['changefreq'] = $this->_option['home']['changefreq'];
            $item['priority'] = $this->_option['home']['priority'];

            return $this->renderPartial('home', ['item' => $item]);
        } elseif ($type === 'p') {
            $postType = PostType::find()->where(['slug' => $slug])->one();
            $posts = $postType->getPosts()
                ->andWhere(['status' => 'publish'])
                ->andWhere(['<=', 'created_at', time()])
                ->offset($page * $this->_option['entries_per_page'])
                ->limit($this->_option['entries_per_page'])
                ->all();

            foreach ($posts as $post) {
                $lastmod = new \DateTime(date('Y-m-d H:i:s',$post->updated_at), new \DateTimeZone(Option::get('time_zone')));
                $items[$post->id]['loc'] = $post->slug;
                $items[$post->id]['lastmod'] = $lastmod->format('r');
                $items[$post->id]['changefreq'] = $this->_option['post_type'][$postType->id]['changefreq'];
                $items[$post->id]['priority'] = $this->_option['post_type'][$postType->id]['priority'];

                if ($images = $post->getMedia()->where(['LIKE', 'mime_type', 'image'])->all()) {
                    foreach ($images as $image) {
                        $metadata = $image->getMeta('metadata');
                        $items[$post->id]['image'][$image->id]['loc'] = $image->getUploadUrl()
                            . $metadata['versions']['full']['url'];
                        $items[$post->id]['image'][$image->id]['title'] = $image->title
                            ? $image->title
                            : null;
                        $items[$post->id]['image'][$image->id]['caption'] = $image->excerpt
                            ? $image->excerpt
                            : null;
                    }
                }
            }

            return $this->renderPartial('post-type', ['items' => $items]);
        } elseif ($type === 'c') {
            $taxonomy = Taxonomy::find()->where(['slug' => $slug])->one();
            $terms = $taxonomy->getTerms()
                ->offset($page * $this->_option['entries_per_page'])
                ->limit($this->_option['entries_per_page'])
                ->all();

            foreach ($terms as $term) {
                $post = $term->getPosts()
                    ->andWhere(['status' => Post::STATUS_PUBLISH])
                    ->andWhere(['<=', 'created_at', time()])
                    ->orderBy(['id' => SORT_DESC])
                    ->one();

                if ($post) {
                    $lastmod = new \DateTime(date('Y-m-d H:i:s',$post->updated_at), new \DateTimeZone(Option::get('time_zone')));
                    $items[$term->id]['loc'] = $term->slug;
                    $items[$term->id]['lastmod'] = $lastmod->format('r');
                    $items[$term->id]['changefreq'] = $this->_option['taxonomy'][$taxonomy->id]['changefreq'];
                    $items[$term->id]['priority'] = $this->_option['taxonomy'][$taxonomy->id]['priority'];
                }
            }

            return $this->renderPartial('taxonomy', ['items' => $items]);
        } elseif ($type === 'm') {
            $mediaSet = Media::find()
                ->offset($page * $this->_option['entries_per_page'])
                ->limit($this->_option['entries_per_page'])
                ->all();
            foreach ($mediaSet as $media) {
                $lastmod = new \DateTime(date('Y-m-d H:i:s',$media->updated_at), new \DateTimeZone(Option::get('time_zone')));
                $items[$media->id]['loc'] = $media->getUrl();
                $items[$media->id]['lastmod'] = $lastmod->format('r');
                $items[$media->id]['changefreq'] = $this->_option['media']['changefreq'];
                $items[$media->id]['priority'] = $this->_option['media']['priority'];
            }

            return $this->renderPartial('media', ['items' => $items]);
        }elseif ($type === 's') {
            $serviceSet = Service::find()
                ->offset($page * $this->_option['entries_per_page'])
                ->limit($this->_option['entries_per_page'])
                ->all();
            foreach ($serviceSet as $service) {
                $lastmod = new \DateTime(date('Y-m-d H:i:s',$service->updated_at), new \DateTimeZone(Option::get('time_zone')));
                $items[$service->id]['loc'] = $service->getUrl();
                $items[$service->id]['lastmod'] = $lastmod->format('r');
                $items[$service->id]['changefreq'] = $this->_option['service']['changefreq'];
                $items[$service->id]['priority'] = $this->_option['service']['priority'];
            }

            return $this->renderPartial('service', ['items' => $items]);
        }

        return $this->redirect(['/site/not-found']);
    }

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        /*  @var $postType \common\models\PostType */
        /*  @var $taxonomy \common\models\Taxonomy */
        if (parent::beforeAction($action)) {
            $this->_option = Option::get('sitemap');

            return true;
        }

        return false;
    }
}
