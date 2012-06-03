<?php
/**
 * Created by JetBrains PhpStorm.
 * User: sel
 * Date: 03.06.12
 * Time: 12:45
 * To change this template use File | Settings | File Templates.
 */

namespace NetBricks\Newsletter;

use \NetBricks\Facade as _;


class Resource extends \Zend_Application_Resource_ResourceAbstract
{

    /**
     * Strategy pattern: initialize resource
     *
     * @return mixed
     */
    public function init()
    {
        _::services()->nb_newsletter_subscription
            ->setNamespace('\NetBricks\Newsletter\Service\Subscription')
            ->setAllowed('guest');

        if (_::request()->get->installation->isOneOf(
            array('installation', 'newsletter_user', 'newsletter'))
        ) {
            $this->installUser();
        }

    }

    private function installUser()
    {
        $userDoc = new \NetBricks\Newsletter\Document\NewsletterUser();
        $userRepo = new \NetBricks\Newsletter\Document\Repository();
        _::couchdb()->initView(
            $userDoc->toArray(),
            $userRepo->designDocumentId,
            $userRepo->viewName);

        _::couchdb()->initView(
            $userDoc->toArray(),
            $userRepo->designDocumentId,
            'by_email',
            'doc.email');

        return $this;
    }

}
