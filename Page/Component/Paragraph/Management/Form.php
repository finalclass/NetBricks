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

namespace NetBricks\Page\Component\Paragraph\Management;

use \NetBricks\Common\Component\Form\Form as BaseForm;
use \NetBricks\Facade as _;
use \NetBricks\Common\Component\Form\MultiLang\TextArea;
use \NetBricks\Common\Component\Form\Hidden;
use \NetBricks\Common\Component\Form\Submit;
use \NetBricks\Common\Component\Extended\DefaultForm;
use \NetBricks\Common\Component\Extended\DefaultForm\ElementContainer;
use \NetBricks\Common\Component\Form\CheckBox;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 02.03.12
 * @time: 11:10
 *
 * @property \NetBricks\Common\Component\Extended\DefaultForm\ElementContainer $text
 */
class Form extends DefaultForm
{

    public function construct()
    {
        $this->setLegend('Paragraphs')
                ->setSubLegend('Set the paragraph text');

        $this->cancel->addParam('action', 'list');
        $this->submit->setLabel('Save');

        $this->addElement(ElementContainer::factory()
                    ->setLabel('Text')
                    ->element(TextArea::factory()->setName('text_translations'))
        )->addElement(ElementContainer::factory()
                    ->setLabel('nb_page_paragraph_is_deletable')
                    ->element(CheckBox::factory()->setName('is_deletable'))
        );
    }

    public function getService()
    {
        return _::services()->paragraph();
    }

    public function redirect()
    {
        _::url()->addParam('action', 'list')->redirect();
    }

}
