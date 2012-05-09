<?php

namespace NetBricks\Article;

use \NetBricks\Article\Model\ArticleModel;
use \NetBricks\Facade as _;
use \NetCore\Factory\Factory;

/**
 * Resource for ArticleModel;
 *
 * Author: MMP
 */
class Resource extends \Zend_Application_Resource_ResourceAbstract
{

    public function init()
    {

        $cnf = $this->getOptions();

        if (!empty($cnf['articles_dir'])) {
            ArticleModel::setDir($cnf['articles_dir']);
        }

        _::services()->article
                ->setNamespace('\NetBricks\Article\Service\Article')
                ->setAllowed('article_admin');
        _::services()->articleReader
                ->setNamespace('\NetBricks\Article\Service\ArticleReader')
                ->setAllowed(array('reader'));
    }

}