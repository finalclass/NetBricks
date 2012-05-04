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
namespace NetBricks\Place\Component\Back;
use \NetBricks\Common\Component\Form\Form as BaseForm;
use \NetBricks\Common\Component\Form\TextInput;
use \NetBricks\Common\Component\Form\Hidden;
use \NetBricks\Common\Component\Form\TextArea;
use \NetBricks\Common\Component\Form\Submit;
use \NetBricks\Common\Component\Form\NicEditor;
use \NetBricks\Common\Component\Form\Address;
use \NetBricks\Page\Component\Photo\PhotosFormElement;
use \NetBricks\Common\Component\Link;
use \NetBricks\Facade as _;
use \NetBricks\Common\Component\Extended\DefaultForm;
use \NetBricks\Common\Component\Extended\DefaultForm\ElementContainer;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 23.04.12
 * @time: 16:54
 */
class Form extends DefaultForm
{

    public function construct()
    {
        $this->setLegend('Places')
                ->setSubLegend('Fill the form and click "Save"');

        $this->addElement(ElementContainer::factory()
                    ->setLabel('Name')
                    ->element(TextInput::factory()->setName('name'))
        )->addElement(ElementContainer::factory()
                    ->setLabel('Telephon')
                    ->element(TextInput::factory()->setName('telephone'))
        )->addElement(ElementContainer::factory()
                    ->setLabel('Address')
                    ->element(Address::factory()->setName('address'))
        )->addElement(ElementContainer::factory()
                    ->setLabel('Information')
                    ->element(NicEditor::factory()->setName('information'))
        )->addElement(ElementContainer::factory()
                    ->setLabel('Description')
                    ->element(NicEditor::factory()->setName('description'))
        )->addElement(ElementContainer::factory()
                    ->setLabel('Photos')
                    ->element(PhotosFormElement::factory()->setName('photos'))
        );

    }

    public function redirect()
    {
        _::url()->addCurrentParams()->addParam('nb_back_place', 'list')->redirect();
    }

    public function getService()
    {
        return new \NetBricks\Place\Service\PlaceService();
    }

}
