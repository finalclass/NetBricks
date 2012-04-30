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
namespace NetBricks\News\Component\Back;
use \NetBricks\Common\Component\Extended\DefaultForm;
use \NetBricks\Common\Component\Extended\DefaultForm\ElementContainer;
use \NetBricks\Common\Component\Form\MultiLang\TextArea;
use \NetBricks\Common\Component\Form\MultiLang\TextInput;
use \NetBricks\Page\Component\Photo\PhotosFormElement;
use \NetBricks\Facade as _;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 29.04.12
 * @time: 12:38
 */
class Form extends DefaultForm
{

    public function construct()
    {
        $this->setLegend('nb_news_back_form_legend')
                ->setSubLegend('nb_news_back_form_sub_legend'
        )->addElement(ElementContainer::factory()
                    ->setLabel('nb_news_back_form_title')
                    ->element(TextInput::factory()->setName('title_translations'))
        )->addElement(ElementContainer::factory()
                    ->setLabel('nb_news_back_form_body')
                    ->element(TextInput::factory()->setName('body_translations'))
        )->addElement(ElementContainer::factory()
                    ->setLabel('nb_news_back_form_photos')
                    ->element(PhotosFormElement::factory()->setName('photos'))
        )->addElement(ElementContainer::factory()
                    ->setLabel('nb_news_back_form_publish_date')
                    ->element(TextInput::factory()->setName('publish_date'))
        )->addElement(ElementContainer::factory()
                    ->setLabel('nb_news_back_form_expire_date')
                    ->element(TextInput::factory()->setName('expire_date'))
        );

        $this->cancel->addData('component', '\NetBricks\News\Component\Back\Table')
            ->addData('destination', '.nb_back_news_container');
    }

    public function redirect()
    {
        _::url()->addParam('list', 'nb_news_back')->addCurrentParams()->redirect();
    }

    public function getService()
    {
        return _::services()->news();
    }

}
