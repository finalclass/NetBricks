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
namespace NetBricks\Common\Component\Form;
use \NetBricks\Common\Component\Form\FormElementAbstract;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 07.05.12
 * @time: 12:41
 */
class MultiCheckBoxes extends FormElementAbstract
{

    /**
     * @static
     * @param string $optionsOrTagName
     * @return \NetBricks\Common\Component\Form\MultiCheckBoxes
     */
    static public function factory($optionsOrTagName = 'input')
    {
        $class = get_called_class();
        return new $class($optionsOrTagName);
    }

    /**
     * @param array $value
     * @return \NetBricks\Common\Component\Form\MultiCheckBoxes
     */
    public function setValue($value)
    {
        $this->options['value'] = (array)$value;
        return $this;
    }

    /**
     * @return array
     */
    public function getValue()
    {
        return (array)@$this->options['value'];
    }

    /**
     * @param array $value
     * @return \NetBricks\Common\Component\Form\MultiCheckBoxes
     */
    public function setSelected($value)
    {
        return $this->setValue($value);
    }

    /**
     * @return array
     */
    public function getSelected()
    {
        return $this->getValue();
    }

    /**
     * @param array $value
     * @return \NetBricks\Common\Component\Form\MultiCheckBoxes
     */
    public function setMultiOptions($value)
    {
        $this->options['multi_options'] = (array)$value;
        return $this;
    }

    /**
     * @return array
     */
    public function getMultiOptions()
    {
        return (array)@$this->options['multi_options'];
    }

    public function isSelected($item)
    {
        return array_search($item, $this->getSelected()) !== false;
    }

    public function render()
    {
        $name = $this->getName() . '[]';
        $selected = $this->getSelected();
        ?>

    <?php foreach ($this->getMultiOptions() as $key => $val): ?>
    <ul class="nb_form_multi_check_boxes">
        <li>
            <label>
                <input type="checkbox"
                       name="<?php echo $name; ?>"
                    <?php if ($this->isSelected($key)): ?>
                       checked="checked"
                    <?php endif; ?>
                       value="<?php echo $key; ?>"/>
                <?php echo $val; ?>
            </label>
        </li>
    </ul>
    <?php endforeach; ?>

    <?php
    }

}
