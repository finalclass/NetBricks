<?php

namespace NetBricks\Article\Component;

use \NetBricks\Facade as _;
use \NetBricks\Article\Model\ArticleModel;
use \NetBricks\Common\Component\ContentSwitcher\ContentSwitcher;
use \NetBricks\Common\Component\ComponentAbstract;

/**
 * ArticleEraser
 *
 * Author: MMP
 */
class ArticleEraser extends ComponentAbstract {

    public $article;

    public function __construct() {

        $article = ArticleModel::find(_::request()->article_id);
        if ($article != null)
            $article->delete();
        header('Location: /admin/articles/list');
    }
}