<?php

namespace NetBricks\News;

use \NetBricks\News\Model\NewsModel;
use \NetBricks\Facade as _;
/**
 * Resource for ArticleModel;
 *
 * Author: MMP
 */
class Resource extends \Zend_Application_Resource_ResourceAbstract {

    public function init() {

        $cnf = $this->getOptions();
        
        if(!empty($cnf['dir'])) {
            NewsModel::setDir($cnf['dir']);
        }

        _::router()->addRoute('edit_news', 'edit-news-{id}',
            array('stage' => 'admin', 'content' => 'news', 'action' => 'form'));

        _::services()->news->setNamespace('\NetBricks\News\Crud');


    }

}