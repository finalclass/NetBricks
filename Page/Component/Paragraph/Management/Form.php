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

/**
 * @author: Sel <s@finalclass.net>
 * @date: 02.03.12
 * @time: 11:10
 *
 * @property \NetBricks\Common\Component\Form\TextArea $text
 * @property \NetBricks\Common\Component\Form\Submit $submit
 * @property \NetBricks\Common\Component\Form\Hidden $id;
 * @property \NetBricks\Common\Component\Form\Hidden $rev;
 */
class Form extends BaseForm
{

    public function __construct($options = array())
    {
        $this->id = new Hidden();
        $this->id->setName('_id');

        $this->rev = new Hidden();
        $this->rev->setName('_rev');

        $this->text = new TextArea();
        $this->text->setName('text');

        $this->submit = new Submit();
        $this->submit->setName('form')->setValue(get_class($this));

        parent::__construct($options);
    }

    public function init()
    {
        if(_::request()->post->form == get_class($this)) {
            $document = _::services()->paragraph()->post(_::request()->post->getArray());
            if(!$document->hasErrors()) {
                _::url()->addParam('action', 'list')->redirect();
            }

            $this->setValues($document->toArray());
        } else {
            $paragraph = _::services()->paragraph()->get(_::request()->get->getArray());
            $this->setValues($paragraph->toArray());
        }

    }

    public function render()
    {
?>
<form <?php echo $this->renderTagAttributes($this->defaultAttributes); ?>>
    <?php echo $this->id; ?>
    <?php echo $this->rev; ?>
    <?php echo $this->text->addClass('wysiwyg'); ?>
    <?php echo $this->submit->setLabel('Save'); ?>
</form>
<?php
    }

}
