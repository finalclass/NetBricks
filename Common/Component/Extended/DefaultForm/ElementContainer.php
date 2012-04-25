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
namespace NetBricks\Common\Component\Extended\DefaultForm;
use \NetBricks\Common\Component\Container;
use \NetBricks\Common\Component\Form\FormElementAbstract;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 25.04.12
 * @time: 01:09
 *
 * @property \NetBricks\Common\Component\ComponentAbstract $element
 * @method element
 */
class ElementContainer extends FormElementAbstract
{

    /**
     * @static
     * @param array $options
     * @return \NetBricks\Common\Component\Extended\DefaultForm\ElementContainer
     */
    static public function factory($options = array())
    {
        $class = get_called_class();
        return new $class($options);
    }

    /**
     * @param string $value
     * @return \NetBricks\Common\Component\Extended\DefaultForm\ElementContainer
     */
    public function setSubLabel($value)
    {
        $this->options['sub_label'] = (string)$value;
        return $this;
    }

    /**
     * @return string
     */
    public function getSubLabel()
    {
        return (string)@$this->options['sub_label'];
    }

    /**
     * @param string $value
     * @return \NetBricks\Common\Component\Extended\DefaultForm\ElementContainer
     */
    public function setLabel($value)
    {
        $this->options['label'] = (string)$value;
        return $this;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return (string)@$this->options['label'];
    }

    public function render()
    {
        $id = \NetCore\Utils\Words::generateWord();
        $element = @(string)$this->element->setId($id);
        $tip = $this->getSubLabel();
        ?>
    <div class="nb-hbox">
        <label for="<?php echo $id; ?>">
            <?php echo $this->getLabel(); ?>
            <?php if ($tip): ?>
            <sub><?php echo $tip; ?></sub>
            <?php endif; ?>
        </label>

        <div class="nb-form-element">
            <?php echo $element; ?>
        </div>
    </div>
    <?php
    }

}
