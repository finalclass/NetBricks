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

namespace NetBricks\Common\Form\MultiLang;

use \NetBricks\Common\Form\FormElementAbstract;
use NetBricks\Common\Form\TextInput as TextInputNormal;

use \NetBricks\Facade as _;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 28.02.12
 * @time: 17:03
 *
 * @property \NetBricks\I18n\Component\LanguageBar $languageBar
 */
class TextInput extends FormElementAbstract
{

    /**
     * @var \NetBricks\Common\Form\TextInput
     */
    private $inputs = array();

    public function __construct($options = array())
    {
        parent::__construct($options);

        foreach(_::languages()->getAvailable() as $l) {
            $input = new TextInputNormal();
            $this->inputs[$l->getCode()] = $input;
            $this->addChild($input);
        }
        $this->languageBar = _::loader('/NetBricks/I18n/Component/LanguageBar')->create();
    }

    public function setName($value)
    {
        parent::setName($value);
        foreach($this->inputs as $lang=>$input) {
            /** @var \NetBricks\Common\Form\TextInput $input */
            $input->setName($value . '[' . $lang . ']');
        }
        return $this;
    }

    public function setValue($value)
    {
        if(!is_array($value)) {
            return $this;
        }
        parent::setValue($value);
        foreach($value as $lang=>$value) {
            if(isset($this->inputs[$lang])) {
                $this->inputs[$lang] = $value;
            }
        }
        return $this;
    }

    public function render()
    {
?>
<div class="text_input_multi_lang">
    <?php echo $this->languageBar; ?>
    <?php foreach($this->inputs as $lang=>$input): ?>
        <div class="text_input_multi_lang_input_container text_input_multi_lang_input_<?php echo $lang; ?>">
            <?php echo $input; ?>
        </div>
    <?php endforeach; ?>
</div>
<?php
    }


}
