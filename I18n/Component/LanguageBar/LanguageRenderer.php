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

namespace NetBricks\I18n\Component\LanguageBar;

use \NetBricks\Common\Component\Extended\Renderer;
use \NetBricks\Facade as _;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 12.03.12
 * @time: 11:42
 */
class LanguageRenderer extends Renderer
{

    /**
     * @return \NetBricks\I18n\Model\Language
     */
    private function getLanguage()
    {
        $data = $this->getData();
        if (!$data instanceof \NetBricks\I18n\Model\Language) {
            throw new \NetBricks\I18n\Exception\WrongModelForRenderer();
        }
        return $this->getData();
    }

    public function render()
    {
        $lang = $this->getLanguage();
        ?>
    <div class="one_language" data-language="<?php echo $lang->getCode(); ?>">
        <img src="<?php echo _::loader('/NetBricks/I18n/Component/LanguageBar/flags/' . $lang->getCode() . '.png')->getPath(); ?>"
             alt="<?php echo $lang->getName(); ?>"
             title="<?php echo $lang->getName(); ?>"/>
            <?php echo $lang->getCode(); ?>
    </div>
    <?php
    }
}
