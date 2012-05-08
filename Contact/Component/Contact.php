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

namespace NetBricks\Contact\Component;

use \NetBricks\Facade as _;
use \NetBricks\Common\Component\Form\Form;

/**
 * @property \NetBricks\Common\Component\Form\TextInput $nameInput
 * @property \NetBricks\Common\Component\Form\TextInput $emailInput
 * @property \NetBricks\Common\Component\Form\TextArea $bodyTextArea
 * @property \NetBricks\Common\Component\Form\Submit $submitButton
 * @property \NetBricks\Common\Component\UnorderedList $errorsList
 */
class Contact extends Form
{

    public $isSent = false;
    public $hasErrors = false;

    public function __construct($options = array())
    {
        parent::__construct($options);
        $ns = '/NetBricks/Common/Component/Form/';
        $f = _::factory()->core->form;
        $this->nameInput = _::loader($ns . 'TextInput')->create()->setName('name');
        $this->emailInput = _::loader($ns . 'TextInput')->create()->setName('email');
        $this->bodyTextArea = _::loader($ns . 'TextArea')->create()->setName('body');
        $this->submitButton = _::loader($ns . 'Submit')->create()
                ->setLabel('Send')
                ->setName('form')
                ->setValue('contact');
        $this->errorsList = _::loader('/NetBricks/Common/Component/UnorderedList')->create()->setClass('errors');

        if(_::request()->isPost() && _::request()->post->form == 'contact') {
            $result = _::services()->contact()->post(_::request()->post->getArray());
            $this->setValues($result);
            if(empty($result['errors'])) {
                $this->isSent = true;
            } else {
                $this->hasErrors = true;
                $this->errorsList->setArrayAsContent($result['errors']);
            }

        }
    }

}
