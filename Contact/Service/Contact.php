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
class Contact
{

    public function post()
    {
        $cfg = _::config()->contact;
        $data = $this->getValidatedAndFilteredPostData();

        $to = $cfg->adminEmail->getString();
        $subject = $cfg->subject->getString();
        $body = $data['body'];
        $headers = 'From: ' . $data['name'] . ' <' . $data['email'] . '>' . "\r\n";

        $result = @mail($to, $subject, $body, $headers);

        if(!$result) {
            $data['errors']['mail'] = 'Send mail failed';
        }

        return $data;
    }

    private function getValidatedAndFilteredPostData()
    {
        $data = array();
        $post = _::request()->post;
        $emailValidator = new \Zend_Validate_EmailAddress();
        $strLenValidator = new \Zend_Validate_StringLength(array('min' => 10));
        $filter = new \Zend_Filter();
        $filter->addFilter(new \Zend_Filter_StringTrim())
            ->addFilter(new \Zend_Filter_StripTags());

        $data['email'] = $filter->filter($post->email->getString());
        $data['name'] = $filter->filter($post->name->getString());
        $data['body'] = $filter->filter($post->body->getString());
        $data['errors'] = array();

        if(!$emailValidator->isValid($data['email'])) {
            $data['errors']['email'] = 'Email address invalid';
        }
        if(!$strLenValidator->isValid($data['body'])) {
            $data['errors']['body'] = 'Please insert at least 10 characters';
        }



        return $data;
    }

}
