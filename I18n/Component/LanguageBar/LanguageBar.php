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

namespace NetBricks\I18n\Component;

use \NetBricks\Common\Component\Tag;
use \NetBricks\Common\Component\ComponentAbstract;
use \NetBricks\I18n\Component\LanguageBar\PrevButton;
use \NetBricks\I18n\Component\LanguageBar\NextButton;
use \NetBricks\Common\Component\Extended\ComboBox;
use \NetBricks\Facade as _;


/**
 * @author: Sel <s@finalclass.net>
 * @date: 11.03.12
 * @time: 13:26
 *
 * @property \NetBricks\Common\Component\ComponentAbstract $prevButton
 * @property \NetBricks\Common\Component\ComponentAbstract $nextButton
 * @property \NetBricks\Common\Component\Extended\ComboBox $comboBox;
 */
class LanguageBar extends Tag
{

    public function __construct($options = array())
    {
        $this->addCSS('nb_i18n_language_bar', array($this, 'getCSS'));
        $this->addJS('nb_i18n_language_bar', array($this, 'getJS'));
        parent::__construct($options);
    }

    protected function construct()
    {
        $this->prevButton = $this->createPrevButton();
        $this->nextButton = $this->createNextButton();
        $this->comboBox = $this->createComboBox();
    }

    private function renderDefaultAtrtibutes()
    {
        return $this->renderTagAttributes(array('class', 'style', 'id'));
    }

    public function getClass()
    {
        if(!isset($this->options['class'])) {
            $this->options['class'] = 'nb_i18n_language_bar';
        }
        return $this->options['class'];
    }

    protected function createPrevButton()
    {
        return new PrevButton();
    }

    protected function createNextButton()
    {
        return new NextButton();
    }

    protected function createComboBox()
    {
        $cb = new ComboBox(array(
            'renderer' => new \NetBricks\I18n\Component\LanguageBar\LanguageRenderer()
        ));
        return $cb;
    }

    protected function beforeRender()
    {
        $this->comboBox->setDataProvider(_::languages()->getAvailable());
    }

    public function getCSS()
    {
        return file_get_contents(_::loader($this)->find('languageBar.css')->getFullPath());
    }

    public function getJS()
    {
        return file_get_contents(_::loader($this)->find('languageBar.js')->getFullPath());
    }

    public function render()
    {
        include _::loader($this)->find('languageBar.phtml')->getFullPath();
    }

}
