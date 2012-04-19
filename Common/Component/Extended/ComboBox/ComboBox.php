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

use \NetBricks\Common\Component\Container;
use \NetBricks\Common\Component\Extended\Renderer\Text as TextRenderer;
use \NetBricks\Common\Component\Extended\Renderer;
use \NetBricks\Facade as _;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 11.03.12
 * @time: 19:31
 *
 * @property \NetBricks\Common\Component\Extended\Renderer $renderer
 *
 */
class ComboBox extends Container
{

    public function __construct($options = array())
    {
        _::cfg()->getHeader()->getScripts()
            ->prepend('/NetBricks/Common/js/nb.js')
            ->prepend('/NetBricks/Common/js/jquery.js');

        if(isset($options['renderer'])) {
            $this->renderer = new $options['renderer']();
        } else {
            $this->renderer = $this->createRenderer();
        }

        parent::__construct($options);
    }

    protected function construct()
    {

    }

    protected function createRenderer()
    {
        return new TextRenderer();
    }

    public function render()
    {
        include _::loader(__CLASS__)->find('comboBox.phtml')->getFullPath();
    }

    /**
     * @param array $value
     * @return \NetBricks\Common\Component\Extended\ComboBox
     */
    public function setDataProvider($value)
    {
        $this->options['data_provider'] = (array)$value;
        return $this;
    }

    /**
     * @return array
     */
    public function getDataProvider()
    {
        return (array)@$this->options['data_provider'];
    }

}
