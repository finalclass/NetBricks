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
namespace NetBricks\Common\Component\Extended;
use \NetBricks\Common\Component\Form\Form as BaseForm;
use \NetBricks\Common\Component\Form\Hidden;
use \NetBricks\Facade as _;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 24.04.12
 * @time: 16:09
 *
 * @property \NetBricks\Common\Component\Form\Hidden $id
 * @property \NetBricks\Common\Component\Form\Hidden $rev
 */
abstract class AbstractForm extends BaseForm
{

    abstract protected function getService();
    abstract public function redirect();

    public function __construct($options = array())
    {
        $this->id = Hidden::factory()->setName('_id');
        $this->rev = Hidden::factory()->setName('_rev');
        parent::__construct($options);
        $this->makeAction();
    }

    final public function makeAction()
    {
        if (_::request()->isPost()) {
            if (_::request()->_id->exists() && _::request()->_rev->exists()) {
                $out = $this->getService()->put(_::request()->post->getArray())->toArray();
            } else {
                $out = $this->getService()->post(_::request()->post->getArray())->toArray();
            }

            if($out) {
                $this->setValues($out);
            }

            if (empty($out['errors'])) {
                $this->redirect();
            }

        } else if (_::request()->get->id->exists()) {
            $document = $this->getService()->get(_::request()->get->getArray());
            if($document) {
                $this->setValues($document->toArray());
            }
        }
    }

    public function formStart()
    {
        return '<form ' . $this->renderTagAttributes($this->getDefaultAttributes()) . '>'
                . $this->id . $this->rev;
    }

    public function formEnd()
    {
        return '</form>';
    }

}
