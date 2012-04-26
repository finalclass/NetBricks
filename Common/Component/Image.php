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

namespace NetBricks\Common\Component;

use \NetBricks\Common\Component\Tag;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 15.03.12
 * @time: 15:02
 */
class Image extends Tag
{

    protected $defaultAttributes = array('src', 'style', 'class', 'id', 'alt', 'width', 'height');

    /**
     * @static
     * @param string $optionsOrTagName
     * @return \NetBricks\Common\Component\Image
     */
    static public function factory($optionsOrTagName = 'div')
    {
        $class = get_called_class();
        return new $class($optionsOrTagName);
    }

    public function render()
    {
        return '<img ' . $this->renderTagAttributes($this->defaultAttributes) . ' ' . $this->renderData() . '/>';
    }

    /**
     * @param string $value
     * @return \NetBricks\Common\Component\Image
     */
    public function setSrc($value)
    {
        $this->options['src'] = (string)$value;
        return $this;
    }

    /**
     * @return string
     */
    public function getSrc()
    {
        return (string)@$this->options['src'];
    }

    /**
     * @param string $value
     * @return \NetBricks\Common\Component\Image
     */
    public function setAlt($value)
    {
        $this->options['alt'] = (string)$value;
        return $this;
    }

    /**
     * @return string
     */
    public function getAlt()
    {
        return (string)@$this->options['alt'];
    }

    /**
     * @param int $value
     * @return \NetBricks\Common\Component\Image
     */
    public function setWidth($value)
    {
        $this->options['width'] = (int)$value;
        return $this;
    }

    /**
     * @return int
     */
    public function getWidth()
    {
        return (int)@$this->options['width'];
    }

    /**
     * @param int $value
     * @return \NetBricks\Common\Component\Image
     */
    public function setHeight($value)
    {
        $this->options['height'] = (int)$value;
        return $this;
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        return (int)@$this->options['height'];
    }

}
