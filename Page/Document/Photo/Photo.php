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

namespace NetBricks\Page\Document;

use \NetCore\CouchDB\Document;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 01.03.12
 * @time: 22:22
 */
class Photo extends Document
{

    protected $data = array(
        'big_src' => '',
        'thumb_src' => '',
        'name' => array(),
        'big_width' => 800,
        'big_height' => 600,
        'thumb_width' => 120,
        'thumb_height' => 80,
    );

    /**
     * @param string $value
     * @return \NetBricks\Page\Document\Photo
     */
    public function setThumbHeight($value)
    {
        $this->data['thumb_height'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getThumbHeight()
    {
        return $this->data['thumb_height'];
    }

    /**
     * @param string $value
     * @return \NetBricks\Page\Document\Photo
     */
    public function setThumbWidth($value)
    {
        $this->data['thumb_width'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getThumbWidth()
    {
        return $this->data['thumb_width'];
    }

    /**
     * @param string $value
     * @return \NetBricks\Page\Document\Photo
     */
    public function setBigHeight($value)
    {
        $this->data['big_height'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getBigHeight()
    {
        return $this->data['big_height'];
    }

    /**
     * @param string $value
     * @return \NetBricks\Page\Document\Photo
     */
    public function setBigWidth($value)
    {
        $this->data['big_width'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getBigWidth()
    {
        return $this->data['big_width'];
    }

    /**
     * @param string $value
     * @return \NetBricks\Page\Document\Photo
     */
    public function setName($value)
    {
        $this->data['name'] = $value;
        return $this;
    }

    /**
     * @param null $language 2 letters country code
     * @return string
     */
    public function getName($language = null)
    {
        if($language != null) {
            return (string) @$this->data['name'][$language];
        }
        return $this->data['name'];
    }

    /**
     * @param string $value
     * @return \NetBricks\Page\Document\Photo
     */
    public function setBigSrc($value)
    {
        $this->data['big_src'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getBigSrc()
    {
        return $this->data['big_src'];
    }

    /**
     * @param string $value
     * @return \NetBricks\Page\Document\Photo
     */
    public function setThumbSrc($value)
    {
        $this->data['thumb_src'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getThumbSrc()
    {
        return $this->data['thumb_src'];
    }

}
