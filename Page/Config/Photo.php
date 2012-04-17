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

namespace NetBricks\Page\Config;

use \NetCore\Configurable\OptionsAbstract;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 04.03.12
 * @time: 15:30
 */
class Photo extends OptionsAbstract
{

    /**
     * @param string $value
     * @return \NetBricks\Page\Config\Photo
     */
    public function setThumbHeight($value)
    {
        $this->options['thumb_height'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getThumbHeight()
    {
        return empty($this->options['thumb_height']) ? 80 : $this->options['thumb_height'];
    }

    /**
     * @param string $value
     * @return \NetBricks\Page\Config\Photo
     */
    public function setThumbWidth($value)
    {
        $this->options['thumb_width'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getThumbWidth()
    {
        return empty($this->options['thumb_width']) ? 120 : $this->options['thumb_width'];
    }

    /**
     * @param string $value
     * @return \NetBricks\Page\Config\Photo
     */
    public function setBigHeight($value)
    {
        $this->options['big_height'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getBigHeight()
    {
        return empty($this->options['big_height']) ? 600 : $this->options['big_height'];
    }

    /**
     * @param string $value
     * @return \NetBricks\Page\Config\Photo
     */
    public function setBigWidth($value)
    {
        $this->options['big_width'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getBigWidth()
    {
        return empty($this->options['big_width']) ? 800 : $this->options['big_width'];
    }

}