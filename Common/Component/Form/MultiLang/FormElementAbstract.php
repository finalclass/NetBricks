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
        $this->initHeader();
        foreach (_::languages()->getAvailable() as $l) {
            $element = $this->createElement();
            $this->elements[$l->getCode()] = $element;
            $this->addChild($element);
        }
        $this->languageBar = _::loader('/NetBricks/I18n/Component/LanguageBar')->create();
        parent::__construct($options);
    }

    private function initHeader()
    {
        $name = 'multi_lang_form_element_abstract';
        $head = _::head();

        if (!$head->scripts->hasScript($name)) {
            $head->scripts->appendScript($this->renderVariable(array($this, 'getJS')), 'text/javascript', $name);
        }
        if (!$head->styleSheets->hasCss($name)) {
            $head->styleSheets->appendCss($this->renderVariable(array($this, 'getCSS')), $name);
        }
    }


    static public function getCSS()
    {
        ?>
    <style type="text/css">
        .multi_lang_form_element {
            display: none;
        }
    </style>
    <?php
    }

    static public function getJS()
    {
        ?>
    <script type="text/javascript">
        $(function () {
            $('.multi_lang_form_element_container').each(function () {
                var $container = $(this);
                var $elements = $container.find('.multi_lang_form_element');
                var $languageBar = $container.find('.language_bar');
                var $current = null;
                var isShiftDown = false;

                $container.keydown(function (event) {
                    if(event.ctrlKey) {
                        if(event.which == 39) { //shift + right arow)
                            $languageBar.data('language_bar').nextLanguage();
                        } else if(event.which == 37){
                            $languageBar.data('language_bar').prevLanguage();
                        }
                    }
                });

                function showCorrectFormElement() {
                    var $oldCurrent = $current ? $current : $elements;
                    var langBarApi = $languageBar.data('language_bar');
                    var langCode = langBarApi ? $languageBar.data('language_bar').selectedLanguage : false;

                    if (langCode) {
                        $current = $container.find('.multi_lang_form_element_' + langCode);
                    } else {
                        $current = $elements.find(':first');
                    }
                    $oldCurrent.slideUp(function () {

                        $current.slideDown().find('input').add($current.find('textarea')).focus();
                    });
                }

                $languageBar.bind('change', showCorrectFormElement);
                showCorrectFormElement();

            });
        });
    </script>
    <?php
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
        <?php echo $this->languageBar; ?>
        <?php foreach ($this->elements as $lang => $element): ?>
        <div class="multi_lang_form_element multi_lang_form_element_<?php echo $lang; ?>">
            <?php echo $element; ?>
        </div>
        <?php endforeach; ?>
    </div>
    <?php
    }

}
