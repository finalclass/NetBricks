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
use \NetBricks\Common\Component\Form\FormElementAbstract;
use \NetBricks\Facade as _;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 30.04.12
 * @time: 10:34
 */
class DatePicker extends FormElementAbstract
{

    public function __construct($options = array())
    {
        parent::__construct($options);
        _::cfg()->getHeader()->getScripts()->addJQueryUi()->addNetBricks();
        $this->addClass('nb_extended_date_picker');
    }

    public function getValue()
    {
        $val = parent::getValue();
        if(!$val) {
            return time() * 1000;
        }
        return $val;
    }

    public function render()
    {
        ?>
    <div class="<?php echo $this->getClass(); ?>"
         id="<?php echo $this->getId(); ?>">
        <input type="text" value="<?php echo date('Y-m-d', $this->getValue()/ 1000); ?>"/>
        <input type="hidden"
               name="<?php echo $this->getName(); ?>"
               value="<?php echo $this->getValue(); ?>"/>
    </div>
    <?php
    }

}
