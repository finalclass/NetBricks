<?php
/**
 * Created by JetBrains PhpStorm.
 * User: sel
 * Date: 03.06.12
 * Time: 12:47
 * To change this template use File | Settings | File Templates.
 */

namespace NetBricks\Newsletter\Service;

use \NetBricks\Facade as _;

class Subscription
{

    public function getRepo()
    {
        return new \NetBricks\Newsletter\Document\Repository();
    }

    public function post($params = array())
    {
        $params = $this->getFilteredAndValidateData($params['post']);
        $document = new \NetBricks\Newsletter\Document\NewsletterUser();
        $document->setEmail($params['email'])
            ->setLanguage($params['language'])
            ->setErrors((array)@$params['errors']);
        if(empty($params['errors'])) {
            return $this->getRepo()->save($params);
        }
        return $document;
    }

    public function getFilteredAndValidateData($params)
    {
        $emailValidator = new \Zend_Validate_EmailAddress();
        $filter = new \Zend_Filter();
        $filter->addFilter(new \Zend_Filter_StringTrim())
            ->addFilter(new \Zend_Filter_StripTags());

        $emailErrors = array();

        $params['email'] = $filter->filter($params['email']);

        $existing = $this->getRepo()->findByEmail($params['email']);
        if($existing) {
            $emailErrors[] = _::translate('nb_newsletter_email_exists');
        }

        if (!$emailValidator->isValid($params['email'])) {
            $emailErrors[] = _::translate('nb_newsletter_email_invalid');
        }

        if(!isset($params['language'])) {
            $params['language'] = _::languages()->getCurrent();
        }

        if(!empty($emailErrors)) {
            $params['errors']['email'] = $emailErrors;
        }

        return $params;

    }

    public function delete($params)
    {
        //@TODO implement un subscribing
    }


    public function subscribe($params)
    {
        return $this->put($post);
    }

    public function unsubscribe($params)
    {
        return $this->delete($params);
    }

}
