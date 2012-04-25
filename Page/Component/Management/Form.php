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

namespace NetBricks\Page\Component\Management;

use \NetBricks\Common\Component\Form\Form as CoreForm;
use \NetBricks\Common\Component\Extended\DefaultForm;
use \NetBricks\Common\Component\Extended\DefaultForm\ElementContainer;
use \NetBricks\Facade as _;
use \NetBricks\Common\Component\Form\MultiLang\TextInput;
use \NetBricks\Common\Component\Form\MultiLang\TextArea;
use \NetBricks\Common\Component\Form\CheckBox;
use \NetBricks\Page\Component\Widget\Management as WidgetManagement;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 24.02.12
 * @time: 10:11
 *
 * @property \NetBricks\Common\Component\Form\MultiLang\TextInput $title
 * @property \NetBricks\Common\Component\Form\MultiLang\TextArea $brief
 * @property \NetBricks\Common\Component\Form\CheckBox $robotsIndex
 * @property \NetBricks\Common\Component\Form\CheckBox $robotsFollow
 * @property \NetBricks\Common\Component\Form\MultiLang\TextInput $metaTitle
 * @property \NetBricks\Common\Component\Form\MultiLang\TextInput $metaKeywords
 * @property \NetBricks\Common\Component\Form\MultiLang\TextArea $metaDescription
 * @property \NetBricks\Common\Component\Form\Submit $submit
 *
 * @property \NetBricks\Page\Component\Widget\Management $widgetManagement
 */
class Form extends DefaultForm
{

    public function construct()
    {
        $this->setLegend('Page')
                ->setSubLegend('Fill the form and click "Save"');

        $this->cancel->addParam('page_management', 'list');
        $this->submit->setLabel('Save');

        $this->addElement(ElementContainer::factory()
                    ->setLabel('Title')
                    ->element(TextInput::factory()->setName('title_translations'))
        )->addElement(ElementContainer::factory()
                    ->setLabel('Brief')
                    ->element(TextInput::factory()->setName('brief_translations'))
        )->addElement(ElementContainer::factory()
                    ->setLabel('Index by robots')
                    ->element(CheckBox::factory()->setname('robots_index'))
        )->addElement(ElementContainer::factory()
                    ->setLabel('Robots follow links?')
                    ->element(CheckBox::factory()->setName('robots_follow'))
        )->addElement(ElementContainer::factory()
                    ->setLabel('Meta title')
                    ->element(TextInput::factory()->setName('meta_title_translations'))
        )->addElement(ElementContainer::factory()
                    ->setLabel('Meta keywords')
                    ->element(TextInput::factory()->setName('meta_keywords_translations'))
        )->addElement(ElementContainer::factory()
                    ->setLabel('Meta description')
                    ->element(TextArea::factory()->setName('meta_description_translations'))
        )->addElement(ElementContainer::factory()
                    ->setLabel('Widget management')
                    ->element(WidgetManagement::factory())
        );
    }


    public function redirect()
    {
        _::url()->addParam('action', 'list')->redirect();
    }

    /**
     * @return \NetBricks\Page\Service\Page
     */
    public function getService()
    {
        return _::services()->page();
    }

    /* public function init()
    {
        if(_::request()->isPost() && _::request()->post->form == 'page_management') {
            $data = $this->getService()->post(_::request()->post->getArray());
            if($data->hasErrors()) {
                $this->setValues($data);
                $this->widgetManagement->setDataProvider($data['widhets']);
            } else {
                _::url()->addParam('action', 'list')->redirect();
            }
        } else if(_::request()->id->exists()){
            $page = $this->getService()->get(_::request()->get->getArray());
            $this->setValues($page);
            $this->widgetManagement->setDataProvider($page->getWidgets());
        }
    }*/


}
