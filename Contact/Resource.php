<?php

namespace NetBricks\Contact;

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
        /**
         * options are email and subject
         */
        _::services()->contact->setNamespace('\NetBricks\Contact\Service\Contact');
        _::config()->contact->setTarget($this->getOptions());
    }

}