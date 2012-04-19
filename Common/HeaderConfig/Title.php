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
namespace NetBricks\Common\HeaderConfig;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 20.03.12
 * @time: 13:15
 */
class Title
{
    private $title = '';
    private $separator = ' - ';

    public function __construct($title)
    {
        $this->title = $title;
    }

    public function setSeparator($seprarator)
    {
        //First explode current title by old separator
        $exploded = explode($this->separator, $this->title);
        $this->separator = $seprarator;
        //Now join with the new glue:
        $this->title = join($this->separator, $exploded);
        return $this;
    }

    public function getSeparator()
    {
        return $this->separator;
    }

    public function add($titlePart)
    {
        $exploded = explode($this->separator, $this->title);
        $exploded[] = $titlePart;
        $this->title = join($this->separator, $this->title);
    }

    public function set($title)
    {
        $this->title = $title;
        return $this;
    }

    public function get()
    {
        return $this->title;
    }

    public function __toString()
    {
        return $this->title;
    }

    public function setOptions($title)
    {
        $this->title = $title;
        return $this;
    }

    public function getOptions()
    {
        return $this->title;
    }
}
