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

/**
 * @author: Sel <s@finalclass.net>
 * @date: 02.03.12
 * @time: 11:10
 *
 * @property \NetBricks\Common\Component\Form\TextArea $text
 * @property \NetBricks\Common\Component\Form\Submit $submit
 */
class Form extends BaseForm
{

    public function __construct($options = array())
    {
        $this->text = new \NetBricks\Common\Component\Form\TextArea();
        $this->text->setName('text');
        $this->submit = new \NetBricks\Common\Component\Form\Submit();
        $this->submit->setName('form')->setValue(get_class($this));
        parent::__construct($options);
    }

    public function init()
    {
        if(_::request()->post->form == get_class($this)) {
            $data = _::services()->paragraph()->post();
            $this->setValues($data->toArray());
            //@TODO error reporting
        } else {
            $paragraph = _::services()->paragraph()->get();
            $this->setValues($paragraph->toArray());
        }
    }

    public function render()
    {
?>
<form <?php echo $this->renderTagAttributes($this->defaultAttributes); ?>>
    <?php echo $this->text->addClass('wysiwyg'); ?>
    <?php echo $this->submit->setLabel('Save'); ?>
</form>
<?php
    }

}
