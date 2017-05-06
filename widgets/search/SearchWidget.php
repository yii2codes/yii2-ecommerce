<?php
/**
* @link https://yii2codes.com/
* @copyright Copyright (c) 2017 Yii2 Codes
* @license https://yii2codes.com/license/
*/

namespace widgets\search;

use common\components\BaseWidget;
use common\models\Option;
use Yii;

class SearchWidget extends BaseWidget
{
    /**
     * @var string Path of the search form. If there is a file search-form.php in directory 'layouts' of active theme,
     * the widget uses it, but if not, the widget uses search-form.php that exist in the directory 'views'.
     */
    private $_searchForm;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $theme = Option::get('theme');
        $searchForm = Yii::getAlias('@themes/' . $theme . '/layouts/search-form.php');

        if (is_file($searchForm)) {
            $this->_searchForm = $searchForm;
        } else {
            $this->_searchForm = __DIR__ . '/views/search-form.php';
        }

        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        echo $this->beforeWidget;

        if ($this->title) {
            echo $this->beforeTitle . $this->title . $this->afterTitle;
        }

        echo Yii::$app->view->renderFile($this->_searchForm);
        echo $this->afterWidget;
    }
}
