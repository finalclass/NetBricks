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

use \NetCore\Configurable\dataAbstract;
use \NetCore\CouchDB\Document;
use \NetBricks\Page\Exception\InvalidWidgetDefinition;
use \NetBricks\Facade as _;
use \NetBricks\Page\Document\Page\Widget;
use \NetBricks\Common\Document\MultiLangDocument;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 28.02.12
 * @time: 11:12
 *
 */
class Page extends MultiLangDocument
{

    protected $data = array(
        'widgets' => array(),
        'title_translations' => array(),
        'meta_title_translations' => array(),
        'meta_description_translations' => array(),
        'meta_keywords_translations' => array(),
        'brief_translations' => array(),
        'robots_index' => true,
        'robots_follow' => true
    );


    /////////////////////////////////////////////////////////////////////////////////////
    // Brief
    /////////////////////////////////////////////////////////////////////////////////////

    /**
     * @param string $value
     * @return \NetBricks\Page\Document\Page
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
    }

    /////////////////////////////////////////////////////////////////////////////////////
    // Meta Keywords
    /////////////////////////////////////////////////////////////////////////////////////

    /**
     * @param string $keyword
     * @return \NetBricks\Page\Document\Page
     */
    public function addMetaKeyword($keyword)
    {
        $languageCode = $this->getLanguage();
        $this->initMetaKeywordsForLanguage($languageCode);
        $this->data['meta_keywords_translations'][$languageCode][$keyword] = $keyword;
        return $this;
    }

    /**
     * @param string $keyword
     * @return \NetBricks\Page\Document\Page
     */
    public function removeMetaKeyword($keyword)
    {
        $languageCode = $this->getLanguage();
        $this->initMetaKeywordsForLanguage($languageCode);
        unset($this->data['meta_keywords_translations'][$languageCode][$keyword]);
        return $this;
    }

    /**
     * @param string $languageCode 2 letters country code
     * @return \Netbricks\Page\Document\Page
     */
    private function initMetaKeywordsForLanguage($languageCode)
    {
        if (!isset($this->data['meta_keywords_translations'][$languageCode])) {
            $this->data['meta_keywords_translations'][$languageCode] = array();
        }
        return $this;
    }

    /**
     * @param string $keyword
     * @return bool
     */
    public function hasKeyword($keyword)
    {
        $languageCode = $this->getLanguage();
        $this->initMetaKeywordsForLanguage($languageCode);
        return isset($this->data['meta_keywords_translations'][$languageCode][(string)$keyword]);
    }


    /**
     * @param $keywordsByLanguage
     * @return \NetBricks\Page\Document\Page
     */
    public function setMetaKeywordsTranslations($keywordsByLanguage)
    {
        $all = array();
        foreach ($keywordsByLanguage as $language => $keywords) {
            $unique = array();
            foreach ($keywords as $k) {
                $unique[$k] = $k;
            }
            $all[$language] = $unique;
        }
        $this->data['meta_keywords_translations'] = $all;
        return $this;
    }

    /**
     * @return array
     */
    public function getMetaKeywordsTranslations()
    {
        return array_values((array)@$this->data['meta_keywords_translations']);
    }

    /**
     * @return array
     */
    public function getMetaKeywords()
    {
        $languageCode = $this->getLanguage();
        $this->initMetaKeywordsForLanguage($languageCode);
        return (array)@$this->data['meta_keywords_translations'][$languageCode];
    }

    public function setMetaKeywords($keywords)
    {
        if (!is_array($keywords)) {
            if (is_string($keywords)) {
                $filter = new \NetCore\Filter\Keywords();
                $keywords = $filter->filter($keywords);
                $keywords = explode(', ', $keywords);
            } else {
                $keywords = array();
            }
        }
        $languageCode = $this->getLanguage();
        $this->initMetaKeywordsForLanguage($languageCode);
        $this->data['meta_keywords_translations'][$languageCode] = $keywords;
    }

    /////////////////////////////////////////////////////////////////////////////////////
    // Meta Description
    /////////////////////////////////////////////////////////////////////////////////////

    /**
     * @param string $value
     * @return \NetBricks\Page\Document\Page
     */
    public function setMetaDescription($value)
    {
        $this->data['meta_description_translations'][$this->getLanguage()] = (string)$value;
        return $this;
    }

    /**
     * @return string
     */
    public function getMetaDescription()
    {
        return (string)@$this->data['meta_description_translations'][$this->getLanguage()];
    }

    /**
     * @return string
     */
    public function getMetaDescriptionTranslations()
    {
        return (array)$this->data['meta_description_translations'];
    }

    public function setMetaDescriptionTranslations($translations)
    {
        $this->data['meta_description_translations'] = $this->filterTranslations($translations);
        return $this;
    }

    /////////////////////////////////////////////////////////////////////////////////////
    // Meta Title
    /////////////////////////////////////////////////////////////////////////////////////

    /**
     * @param string $value
     * @return \NetBricks\Page\Document\Page
     */
    public function setMetaTitle($value)
    {
        $this->data['meta_title_translations'][$this->getLanguage()] = (string)$value;
        return $this;
    }

    /**
     * @return array
     */
    public function getMetaTitle()
    {
        return (array)@$this->data['meta_title_translations'][$this->getLanguage()];
    }

    /**
     * @return string
     */
    public function getMetaTitleTranslations()
    {
        return (array)@$this->data['meta_title_translations'];
    }

    /**
     * @param $translations
     * @return \NetBricks\Page\Document\Page
     */
    public function setMetaTitleTranslations($translations)
    {
        $this->data['meta_title_translations'] = $this->filterTranslations($translations);
        return $this;
    }

    /////////////////////////////////////////////////////////////////////////////////////
    // Widgets
    /////////////////////////////////////////////////////////////////////////////////////

    /**
     * @param array|\NetBricks\Page\Document\Page\Widget[] $widgets
     * @return \NetBricks\Page\Document\Page
     */
    public function setWidgets(array $widgets)
    {
        $all = array();
        foreach ($widgets as $w) {
            if (is_array($w)) {
                $widget = new Widget($w);
            } else if ($w instanceof Widget) {
                $widget = $w;
            } else {
                throw new InvalidWidgetDefinition();
            }
            $all[] = $widget;
        }
        $this->data['widgets'] = $all;
        return $this;
    }

    /**
     * @return \NetBricks\Page\Document\Page\Widget[]
     */
    public function getWidgets()
    {
        return (array)@$this->data['widgets'];
    }

    /**
     * @param \NetBricks\Page\Document\Page\Widget $widget
     * @param $position
     * @return \NetBricks\Page\Document\Page
     */
    public function addWidgetAt(Widget $widget, $position)
    {
        $this->data['widgets'][$position] = $widget;
        return $this;
    }

    /**
     * @param \NetBricks\Page\Document\Page\Widget $widget
     * @return \NetBricks\Page\Document\Page
     */
    public function addWidget(Widget $widget)
    {
        return $this->addWidgetAt($widget, count($this->data['widgets']));
    }

    /**
     * @param $position
     * @return \NetBricks\Page\Document\Page
     */
    public function removeWidgetAt($position)
    {
        unset($this->data['widgets'][$position]);
        return $this;
    }

    /**
     * @param $position
     * @return null|\NetBricks\Page\Document\Page\Widget
     */
    public function getWidgetByPosition($position)
    {
        return isset($this->data['widgets'][$position]) ? $this->data['widgets'][$position] : null;
    }

    /////////////////////////////////////////////////////////////////////////////////////
    // Title
    /////////////////////////////////////////////////////////////////////////////////////

    /**
     * @param array $value
     * @return \NetBricks\Page\Document\Page
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
        return (array)@$this->data['title_translations'][$this->getLanguage()];
    }

    public function getTitleTranslations()
    {
        return (array)@$this->data['title_translations'];
    }

    public function setTitleTranslations($translations)
    {
        $this->data['title_translations'] = $this->filterTranslations($translations);
        return $this;
    }

    /////////////////////////////////////////////////////////////////////////////////////
    // Robots index
    /////////////////////////////////////////////////////////////////////////////////////

    /**
     * @param boolean $value
     * @return \NetBricks\Page\Document\Page
     */
    public function setRobotsIndex($value)
    {
        $this->data['robots_index'] = (boolean)$value;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getRobotsIndex()
    {
        return (boolean)@$this->data['robots_index'];
    }

    /////////////////////////////////////////////////////////////////////////////////////
    // Robots follow
    /////////////////////////////////////////////////////////////////////////////////////

    /**
     * @param boolean $value
     * @return \NetBricks\Page\Document\Page
     */
    public function setRobotsFollow($value)
    {
        $this->data['robots_follow'] = (boolean)$value;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getRobotsFollow()
    {
        return (boolean)@$this->data['robots_follow'];
    }

}
