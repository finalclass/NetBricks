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
namespace NetBricks\News\Model;

use \NetBricks\Common\Document\MultiLangDocument;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 23.04.12
 * @time: 14:28
 */
class NewsDocument extends MultiLangDocument
{

    protected $data = array(
        'title_translations' => array(),
        'body_translations' => array(),
        'brief_translations' => array(),
        'main_photo' => array(),
        'photos' => array(),
        'publish_date' => 0,
        'expire_date' => 0
    );

    /////////////////////////////////////////////////////////////////////////////////////
    // Title
    /////////////////////////////////////////////////////////////////////////////////////

    /**
     * @param string $value
     * @return \NetBricks\News\Model\NewsDocument
     */
    public function setTitle($value)
    {
        $this->data['title_translations'][$this->getLanguage()] = (string)$value;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return (string)@$this->data['title_translations'][$this->getLanguage()];
    }

    /**
     * @return array
     */
    public function getTitleTranslations()
    {
        return (array)@$this->data['title_translations'];
    }

    public function setTitleTranslations(array $value)
    {
        $this->data['title_translations'] = $this->filterTranslations($value);
        return $this;
    }

    /////////////////////////////////////////////////////////////////////////////////////
    // Brief
    /////////////////////////////////////////////////////////////////////////////////////

    /**
     * @param string $value
     * @return \NetBricks\News\Model\NewsDocument
     */
    public function setBrief($value)
    {
        $this->data['brief_translations'][$this->getLanguage()] = (string)$value;
        return $this;
    }

    /**
     * @return string
     */
    public function getBrief()
    {
        return (string)@$this->data['brief_translations'][$this->getLanguage()];
    }

    /**
     * @return array
     */
    public function getBriefTranslations()
    {
        return (array)@$this->data['brief_translations'];
    }

    public function setBriefTranslations(array $value)
    {
        $this->data['brief_translations'] = $this->filterTranslations($value);
        return $this;
    }

    /////////////////////////////////////////////////////////////////////////////////////
    // Body
    /////////////////////////////////////////////////////////////////////////////////////

    /**
     * @param string $value
     * @return \NetBricks\News\Model\NewsDocument
     */
    public function setBody($value)
    {
        $this->data['body_translations'][$this->getLanguage()] = (string)$value;
        return $this;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return (string)@$this->data['body_translations'][$this->getLanguage()];
    }

    /**
     * @return array
     */
    public function getBodyTranslations()
    {
        return (array)@$this->data['body_translations'];
    }

    public function setBodyTranslations(array $value)
    {
        $this->data['body_translations'] = $this->filterTranslations($value);
        return $this;
    }

    /////////////////////////////////////////////////////////////////////////////////////
    // Photos
    /////////////////////////////////////////////////////////////////////////////////////

    /**
     * @param array $value
     * @return \NetBricks\News\Model\NewsDocument
     */
    public function setPhotos($value)
    {
        $this->data['photos'] = (array)$value;
        return $this;
    }

    /**
     * @return array
     */
    public function getPhotos()
    {
        return (array)@$this->data['photos'];
    }
    
    /////////////////////////////////////////////////////////////////////////////////////
    // Main Photo
    /////////////////////////////////////////////////////////////////////////////////////

    /**
     * @param array $value
     * @return \NetBricks\News\Model\NewsDocument
     */
    public function setMainPhoto($value)
    {
        $this->data['main_photo'] = (array)$value;
        return $this;
    }

    /**
     * @return array
     */
    public function getMainPhoto()
    {
        return (array)@$this->data['main_photo'];
    }

    /////////////////////////////////////////////////////////////////////////////////////
    // Publish Date
    /////////////////////////////////////////////////////////////////////////////////////

    /**
     * @param float $value
     * @return \NetBricks\News\Model\NewsDocument
     */
    public function setPublishDate($value)
    {
        $this->data['publish_date'] = (float)$value;
        return $this;
    }

    /**
     * @return float
     */
    public function getPublishDate()
    {
        return (int)@$this->data['publish_date'];
    }

    /////////////////////////////////////////////////////////////////////////////////////
    // Expire Date
    /////////////////////////////////////////////////////////////////////////////////////

    /**
     * @param float $value
     * @return \NetBricks\News\Model\NewsDocument
     */
    public function setExpireDate($value)
    {
        $this->data['expire_date'] = (float)$value;
        return $this;
    }

    /**
     * @return float
     */
    public function getExpireDate()
    {
        return (int)@$this->data['expire_date'];
    }

}
