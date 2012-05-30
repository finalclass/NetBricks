<?php
/**

Copyright (C) Szymon Wygnanski (s@finalclass.net)

Permission is hereby granted, free of charge, to any person obtaining a copy of
this software and associated documentation files (the "Software"), to deal in
the Software without restriction, including without limitation the rights to
use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies
of the Software, and to permit persons to whom the Software is furnished to do
so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
 */

namespace NetBricks\Contact\Service;
use \NetBricks\Facade as _;

/*
 * @author: Sel <s@finalclass.net>
 * @date: 27.12.11
 * @time: 15:03
 */
class Contact extends \NetCore\Configurable\OptionsAbstract
{

    private $params = array();

    public function post($params)
    {
        $this->params = $params;
        $data = $this->getValidatedAndFilteredPostData();
        $to = $this->getEmail();
        $subject = $this->getSubject();
        $body = $data['body'];
        $headers = 'From: ' . $data['name'] . ' <' . $data['email'] . '>' . "\r\n";

        if (empty($data['errors'])) {
            $result = @mail($to, $subject, $body, $headers);
            if (!$result) {
                $data['errors']['mail'] = 'nb_contact_send_failed';
            }
        }

        return $data;
    }

    private function getValidatedAndFilteredPostData()
    {
        $data = array();
        $post = $this->params;
        $emailValidator = new \Zend_Validate_EmailAddress();
        $strLenValidator = new \Zend_Validate_StringLength(array('min' => 10));
        $filter = new \Zend_Filter();
        $filter->addFilter(new \Zend_Filter_StringTrim())
                ->addFilter(new \Zend_Filter_StripTags());

        $data['email'] = $filter->filter(@(string)$post['email']);
        $data['name'] = $filter->filter(@(string)$post['name']);
        $data['body'] = $filter->filter(@(string)$post['body']);
        $data['errors'] = array();

        if (!$emailValidator->isValid($data['email'])) {
            $data['errors']['email'] = 'nb_contact_email_invalid';
        }
        if (!$strLenValidator->isValid($data['body'])) {
            $data['errors']['body'] = 'nb_contact_body_too_short';
        }
        return $data;
    }

    /**
     * @param string $value
     * @return \NetBricks\Contact\Service\Contact
     */
    public function setEmail($value)
    {
        $this->options['email'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return empty($this->options['email']) ? '' : $this->options['email'];
    }

    /**
     * @param string $value
     * @return \NetBricks\Contact\Service\Contact
     */
    public function setSubject($value)
    {
        $this->options['subject'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return empty($this->options['subject']) ? '' : $this->options['subject'];
    }

}
