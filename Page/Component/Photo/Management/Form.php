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

namespace NetBricks\Page\Component\Photo\Management;

use \NetBricks\Common\Component\Form\Form as BaseForm;
use \NetBricks\Facade as _;
use \NetBricks\Common\Component\Extended\DefaultForm;
use \NetBricks\Common\Component\Extended\DefaultForm\ElementContainer;
use \NetBricks\Common\Component\Form\MultiLang\TextInput;
use \NetBricks\Common\Component\Form\File;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 04.03.12
 * @time: 15:55
 *
 * @property \NetBricks\Common\Component\Form\Hidden $id
 * @property \NetBricks\Common\Component\Form\Hidden $rev
 * @property \NetBricks\Common\Component\Form\MultiLang\TextInput $name
 * @property \NetBricks\Common\Component\Form\File $file
 * @property \NetBricks\Common\Component\Form\Submit $submit
 */
class Form extends DefaultForm
{

    private $existingPhotoSrc = '';

    public function construct()
    {
        $this->setLegend('Photos')
                ->setSubLegend('Upload photo or change its label');

        $this->cancel->addParam('action', 'list');

        $this->submit->setLabel('Save');

        $this->addElement(ElementContainer::factory()
                    ->setLabel('Photo label')
                    ->setSubLabel('The name of the photo')
                    ->element(TextInput::factory()->setName('name_translations'))
        )->addElement(ElementContainer::factory()
                    ->setLabel('Photo file')
                    ->setSubLabel('Select file from your harddrive')
                    ->element(File::factory()->setName('photo'))
        );

        $this->existingPhoto = new \NetBricks\Page\Component\Photo\Thumb();

    }

    protected function getService()
    {
        return _::services()->photo();
    }

    public function setValues($values)
    {
        parent::setValues($values);
        $this->existingPhotoSrc = _::couchdb()->getUrl() . '/' . $values['_id'] . '/thumb.jpg';
    }

    public function redirect()
    {
        $values = $this->getValues();
        _::url()->addCurrentParams()
                ->addParam('action', 'list')
                ->addParam('new_photo_id', @$values['_id'])
                ->redirect();
    }

    public function render()
    {
        if($this->existingPhotoSrc) {
            echo '<img src="' . $this->existingPhotoSrc . '" />';
        }
        return parent::render();
    }

}
