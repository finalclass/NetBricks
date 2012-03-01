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

use \NetBricks\Common\Form\Form as CoreForm;
use \NetBricks\Facade as _;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 24.02.12
 * @time: 10:11
 *
 * @property \NetBricks\Common\Form\MultiLang\TextInput $title
 * @property \NetBricks\Common\Form\Submit $submit
 */
class Form extends CoreForm
{

    public function __construct($options = array())
    {
        parent::__construct($options);
        $this->title = _::loader('/NetBricks/Common/Form/MultiLang/TextInput')->create()
                            ->setName('title');

        $this->submit = _::loader('/NetBricks/Common/Form/Submit')->create();
    }


    public function render()
    {
?>
<form <?php echo $this->renderTagAttributes($this->defaultAttributes); ?>>
    
    <p>
        <label for="page_title">
            Tytuł
        </label>
        <?php echo $this->title->setId('page_title'); ?>
    </p>

    <?php echo $this->submit->setLabel('Save'); ?>

</form>
<?php
    }

}
