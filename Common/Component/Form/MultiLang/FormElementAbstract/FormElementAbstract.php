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

namespace NetBricks\Common\Component\Form\MultiLang;

use \NetBricks\Facade as _;
use \NetBricks\Common\Component\Form\FormElementAbstract as BaseFormElementAbstract;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 04.03.12
 * @time: 12:18
 *
 * @property \NetBricks\I18n\Component\LanguageBar $languageBar
 */
abstract class FormElementAbstract extends BaseFormElementAbstract
{
    protected $elements = array();

    abstract protected function createElement();

    public function __construct($options = array())
    {
        _::cfg()->getHeader()->getScripts()
                ->prepend('/NetBricks/Common/js/nb.js')
                ->prepend('/NetBricks/Common/js/jquery.js');

        foreach (_::languages()->getAvailable() as $l) {
            $element = $this->createElement();
            $this->elements[$l->getCode()] = $element;
            $this->addChild($element);
        }
        $this->languageBar = _::loader('/NetBricks/I18n/Component/LanguageBar')->create();
        parent::__construct($options);
    }

    public function setName($value)
    {
        parent::setName($value);
        foreach ($this->elements as $lang => $element) {
            $element->setName($value . '[' . $lang . ']');
        }
        return $this;
    }

    public function setValue($values)
    {
        if (!is_array($values)) {
            return $this;
        }
        parent::setValue($values);
        foreach ($values as $lang => $value) {
            if (isset($this->elements[$lang])) {
                $this->elements[$lang]->setValue($value);
            }
        }
        return $this;
    }

    public function render()
    {
        ?>
    <div class="multi_lang_form_element_container">
        <?php foreach ($this->elements as $lang => $element): ?>
        <div class="multi_lang_form_element multi_lang_form_element_<?php echo $lang; ?>">
            <?php echo $element; ?>
        </div>
        <?php endforeach; ?>
        <?php echo $this->languageBar; ?>
    </div>
    <?php
    }

}
