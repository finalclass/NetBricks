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

use \NetBricks\Common\Document\MultiLangDocument;
use \NetBricks\Facade as _;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 01.03.12
 * @time: 22:22
 */
class Photo extends MultiLangDocument
{

    protected $data = array(
        'big_width' => 800,
        'big_height' => 600,
        'thumb_width' => 120,
        'thumb_height' => 80,
        'icon_width' => 16,
        'icon_height' => 16,
        'tiny_width' => 160,
        'tiny_height' => 120,
        'middle_width' => 400,
        'middle_height' => 300,
        'name_translations' => array(),
    );


    ////////////////////////////////////////////////////////////////
    // Icon
    ////////////////////////////////////////////////////////////////

    /**
     * @param string $value
     * @return \NetBricks\Page\Document\Photo
     */
    public function setIconHeight($value)
    {
        $this->data['icon_height'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getIconHeight()
    {
        return $this->data['icon_height'];
    }

    /**
     * @param string $value
     * @return \NetBricks\Page\Document\Photo
     */
    public function setIconWidth($value)
    {
        $this->data['icon_width'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getIconWidth()
    {
        return $this->data['icon_width'];
    }

    public function getIconSrc()
    {
        return _::couchdb()->getUrl() . '/' . $this->getId() . '/icon.jpg';
    }

    ////////////////////////////////////////////////////////////////
    // Thumb
    ////////////////////////////////////////////////////////////////

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

    public function getThumbSrc()
    {
        return _::couchdb()->getUrl() . '/' . $this->getId() . '/thumb.jpg';
    }

    ////////////////////////////////////////////////////////////////
    // Tiny
    ////////////////////////////////////////////////////////////////

    /**
     * @param string $value
     * @return \NetBricks\Page\Document\Photo
     */
    public function setTinyHeight($value)
    {
        $this->data['tiny_height'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getTinyHeight()
    {
        return $this->data['tiny_height'];
    }

    /**
     * @param string $value
     * @return \NetBricks\Page\Document\Photo
     */
    public function setTinyWidth($value)
    {
        $this->data['tiny_width'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getTinyWidth()
    {
        return $this->data['tiny_width'];
    }

    public function getTinySrc()
    {
        return _::couchdb()->getUrl() . '/' . $this->getId() . '/tiny.jpg';
    }

    ////////////////////////////////////////////////////////////////
    // Middle
    ////////////////////////////////////////////////////////////////

    /**
     * @param string $value
     * @return \NetBricks\Page\Document\Photo
     */
    public function setMiddleHeight($value)
    {
        $this->data['middle_height'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getMiddleHeight()
    {
        return $this->data['middle_height'];
    }

    /**
     * @param string $value
     * @return \NetBricks\Page\Document\Photo
     */
    public function setMiddleWidth($value)
    {
        $this->data['middle_width'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getMiddleWidth()
    {
        return $this->data['middle_width'];
    }

    public function getMiddleSrc()
    {
        return _::couchdb()->getUrl() . '/' . $this->getId() . '/middle.jpg';
    }

    ////////////////////////////////////////////////////////////////
    // Big
    ////////////////////////////////////////////////////////////////

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


    public function getBigSrc()
    {
        return _::couchdb()->getUrl() . '/' . $this->getId() . '/big.jpg';
    }


    ////////////////////////////////////////////////////////////////
    // Original
    ////////////////////////////////////////////////////////////////


    public function getOriginalSrc()
    {
        return _::couchdb()->getUrl() . '/' . $this->getId() . '/original.jpg';
    }

    /////////////////////////////////////////////////////////////////////////////////////
    // Name
    /////////////////////////////////////////////////////////////////////////////////////

    /**
     * @param string $value
     * @return \NetBricks\Page\Document\Photo
     */
    public function setName($value)
    {
        $this->data['name_translations'][$this->getLanguage()] = (string)$value;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return (string)@$this->data['name_translations'][$this->getLanguage()];
    }

    /**
     * @param array $value
     * @return \NetBricks\Page\Document\Photo
     */
    public function setNameTranslations(array $value)
    {
        $this->data['name_translations'] = $this->filterTranslations($value);
        return $this;
    }

    /**
     * @return array
     */
    public function getNameTranslations()
    {
        return (array)@$this->data['name_translations'];
    }

}
