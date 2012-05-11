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

/**
 * @author: Sel <s@finalclass.net>
 * @date: 01.03.12
 * @time: 22:22
 */
class Paragraph extends MultiLangDocument
{

    protected $data = array(
        'text_translations' => array(),
        'is_deletable' => true,
    );

    /**
     * @param boolean $value
     * @return \NetBricks\Page\Document\Paragraph
     */
    public function setIsDeletable($value)
    {
        $this->data['is_deletable'] = (boolean)$value;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getIsDeletable()
    {
        return isset($this->data['is_deletable']) ? $this->data['is_deletable'] : true;
    }

    /**
     * @param string $value
     * @return \NetBricks\Page\Document\Paragraph
     */
    public function setText($value)
    {
        $this->data['text_translations'][$this->getLanguage()] = (string)$value;
        return $this;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return (string)@$this->data['text_translations'][$this->getLanguage()];
    }

    /**
     * @param array $value
     * @return \NetBricks\Page\Document\Paragraph
     */
    public function setTextTranslations($value)
    {
        $this->data['text_translations'] = (array)$value;
        return $this;
    }

    /**
     * @return array
     */
    public function getTextTranslations()
    {
        return (array)@$this->data['text_translations'];
    }

}
