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
class Form extends BaseForm
{

    public function __construct($options = array())
    {
        $this->id = _::loader('\NetBricks\Common\Component\Form\Hidden')->create()->setName('_id');
        $this->rev = _::loader('\NetBricks\Common\Component\Form\Hidden')->create()->setName('_rev');
        $this->name = _::loader('\NetBricks\Common\Component\Form\MultiLang\TextInput')->create()
                ->setName('name_translations');
        $this->file = _::loader('\NetBricks\Common\Component\Form\File')->create()->setName('photo');
        $this->submit = _::loader('\NetBricks\Common\Component\Form\Submit')->create()->setLabel('Save')
                            ->setName('form')->setValue('page_photo_form');
        $this->setEncType('multipart/form-data');
        parent::__construct($options);
    }

    private function getService()
    {
        return new \NetBricks\Page\Service\Photo();
    }

    public function init()
    {
        if(_::request()->isPost() && _::request()->post->form->toString() == 'page_photo_form') {
            $result = $this->getService()->post();
            if(!$result->hasErrors()) {
                _::url()->addParam('action', 'list')->redirect();
            }
            $this->setValues($result->toArray());
        } else {
            $this->setValues($this->getService()->get()->toArray());
        }
    }

    public function render()
    {
        ?>
<form <?php echo $this->renderTagAttributes($this->defaultAttributes); ?>>
    <?php echo $this->id; ?>
    <?php echo $this->rev; ?>
    <p>
        <label for="photo_name">Photo name</label>
        <?php echo $this->name->setId('photo_name'); ?>
    </p>
    <p>
        <label for="photo_file">Photo file</label>
        <?php echo $this->file->setId('photo_file'); ?>
    </p>
    <?php echo $this->submit; ?>
</form>
        <?php
    }

}
