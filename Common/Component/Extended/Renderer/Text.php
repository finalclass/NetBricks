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
namespace NetBricks\Common\Component\Extended\Renderer;

use \NetBricks\Common\Component\Extended\Renderer;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 11.03.12
 * @time: 19:34
 */
class Text extends Renderer
{

    /**
     * @param string $value
     * @return \NetBricks\Common\Component\Form\Extended\Renderer\Text
     */
    public function setLabelField($value)
    {
        $this->options['label_field'] = (string)$value;
        return $this;
    }

    /**
     * @return string
     */
    public function getLabelField()
    {
        return isset($this->options['label_field'])
                ? (string)$this->options['label_field'] : 'name';
    }

    public function render()
    {
        return \NetCore\Renderer::renderObjectProperty($this->getData(), $this->getLabelField());
    }

}