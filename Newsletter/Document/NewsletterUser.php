<?php
/**
 * Created by JetBrains PhpStorm.
 * User: sel
 * Date: 03.06.12
 * Time: 12:50
 * To change this template use File | Settings | File Templates.
 */

namespace NetBricks\Newsletter\Document;

use \NetCore\CouchDB\Document;

class NewsletterUser extends Document
{

    protected $data = array(
        'email' => '',
        'newsletter_channels' => array(),
        'language' => ''
    );

    /////////////////////////////////////////////////////////////////////////////////////
    // Email
    /////////////////////////////////////////////////////////////////////////////////////

    /**
     * @param boolean $value
     * @return \NetBricks\Newsletter\Document
     */
    public function setEmail($value)
    {
        $this->data['email'] = (string)$value;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getEmail()
    {
        return (string)@$this->data['email'];
    }


    /////////////////////////////////////////////////////////////////////////////////////
    // NewsletterChannels
    /////////////////////////////////////////////////////////////////////////////////////

    /**
     * @param boolean $value
     * @return \NetBricks\Newsletter\Document
     */
    public function setNewsletterChannels($value)
    {
        $this->data['newsletter_channels'] = (array)$value;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getNewsletterChannels()
    {
        return (array)@$this->data['newsletter_channels'];
    }

    /////////////////////////////////////////////////////////////////////////////////////
    // Language
    /////////////////////////////////////////////////////////////////////////////////////

    /**
     * @param boolean $value
     * @return \NetBricks\Newsletter\Document
     */
    public function setLanguage($value)
    {
        $this->data['language'] = (string)$value;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getLanguage()
    {
        return (string)@$this->data['language'];
    }

}
