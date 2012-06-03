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

    public function put($params)
    {
        $params = $this->getFilteredAndValidateData($params);
        return $this->getRepo()->save($params);
    }

    public function post($params)
    {
        return $this->put($params);
    }

    public function getFilteredAndValidateData($params)
    {
        $emailValidator = new \Zend_Validate_EmailAddress();
        $filter = new \Zend_Filter();
        $filter->addFilter(new \Zend_Filter_StringTrim())
            ->addFilter(new \Zend_Filter_StripTags());

        if(isset($params['email']) && ! isset($params['_id'])) {
            $params['_id'] = $params['email'];
        }

        $params['_id'] = $filter->filter(@(string)$params['_id']);

        if (!$emailValidator->isValid($params['_id'])) {
            $params['errors']['_id'] = 'nb_newsletter_email_invalid';
            $params['errors']['email'] = 'nb_newsletter_email_invalid';
        }

        if(!isset($params['language'])) {
            $params['language'] = _::languages()->getCurrent();
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
