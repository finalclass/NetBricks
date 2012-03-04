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

/*
 * @author: Sel <s@finalclass.net>
 * @date: 28.12.11
 * @time: 15:16
 */
class IconLink extends Link
{

    /**
     * @static
     * @param array $options
     * @return \NetBricks\Common\Component\IconLink
     */
    static public function factory($options = array())
    {
        $class = get_called_class();
        return new $class($options);
    }

    public function __construct($options = array())
    {
        parent::__construct($options);
    }

    public function getContent()
    {
        return '<span class="' . $this->getIconClass() . '"></span>'
                . PHP_EOL
                . parent::getContent();
    }

    /**
     * @param string $value
     * @return \NetBricks\Common\Component\IconLink
     */
    public function setIconClass($value)
    {
        $this->options['icon_class'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getIconClass()
    {
        return empty($this->options['icon_class']) ? '' : $this->options['icon_class'];
    }

}
