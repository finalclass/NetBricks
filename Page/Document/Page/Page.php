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

/**
 * @author: Sel <s@finalclass.net>
 * @date: 28.02.12
 * @time: 11:12
 *
 */
class Page extends Document
{

    protected $data = array(
        'widgets' => array(),
        'title' => array(),
        'meta_title' => array(),
        'meta_description' => array(),
        'meta_keywords' => array(),
        'brief' => array()
    );

    /**
     * @param array $value
     * @return \NetBricks\Page\Document\Page
     */
    public function setBrief(array $value)
    {
        $this->data['brief'] = (array)$value;
        return $this;
    }

    /**
     * @return array
     */
    public function getBrief()
    {
        return (array)@$this->data['brief'];
    }

    /**
     * @param string $languageCode 2 letters country code
     * @return string
     */
    public function getBriefForLanguage($languageCode = null)
    {
        if (!$languageCode) {
            $languageCode = _::languages()->getCurrent();
        }
        return (string)@$this->data['brief'][$languageCode];
    }

    /**
     * @param string $keyword
     * @param string $languageCode 2 letters country code
     * @return \NetBricks\Page\Document\Page
     */
    public function addMetaKeyword($keyword, $languageCode = null)
    {
        if (!$languageCode) {
            $languageCode = _::languages()->getCurrent();
        }
        $this->initMetaKeywordsForLanguage($languageCode);
        $this->data['meta_keywords'][$languageCode][$keyword] = $keyword;
        return $this;
    }

    /**
     * @param string $keyword
     * @param string $languageCode 2 letters country code
     * @return \NetBricks\Page\Document\Page
     */
    public function removeMetaKeyword($keyword, $languageCode = null)
    {
        if (!$languageCode) {
            $languageCode = _::languages()->getCurrent();
        }
        $this->initMetaKeywordsForLanguage($languageCode);
        unset($this->data['meta_keywords'][$languageCode][$keyword]);
        return $this;
    }

    /**
     * @param string $languageCode 2 letters country code
     * @return \Netbricks\Page\Document\Page
     */
    private function initMetaKeywordsForLanguage($languageCode)
    {
        if (!isset($this->data['meta_keywords'][$languageCode])) {
            $this->data['meta_keywords'][$languageCode] = array();
        }
        return $this;
    }

    /**
     * @param string $keyword
     * @param string $languageCode 2 letters country code
     * @return bool
     */
    public function hasKeyword($keyword, $languageCode = null)
    {
        if(!$languageCode) {
            $languageCode = _::languages()->getCurrent();
        }
        $this->initMetaKeywordsForLanguage($languageCode);
        return isset($this->data['meta_keywords'][$languageCode][(string)$keyword]);
    }


    /**
     * @param $keywordsByLanguage
     * @return \NetBricks\Page\Document\Page
     */
    public function setMetaKeywords($keywordsByLanguage)
    {

        $all = array();
        foreach ($keywordsByLanguage as $language=>$keywords) {
            $unique = array();
            foreach($keywords as $k) {
                $unique[$k] = $k;
            }
            $all[$language] = $unique;
        }
        $this->data['meta_keywords'] = $all;
        return $this;
    }

    /**
     * @return array
     */
    public function getMetaKeywords()
    {
        return array_values((array)@$this->data['meta_keywords']);
    }

    /**
     * @param string $languageCode 2 letters country code
     * @return array
     */
    public function getMetaKeywordsForLanguage($languageCode = null)
    {
        if(!$languageCode) {
            $languageCode = _::languages()->getCurrent();
        }
        $this->initMetaKeywordsForLanguage($languageCode);
        return (array)@$this->data['meta_keywords'][$languageCode];
    }

    /**
     * @param array $value
     * @return \NetBricks\Page\Document\Page
     */
    public function setMetaDescription($value)
    {
        $this->data['meta_description'] = (array)$value;
        return $this;
    }

    /**
     * @return array
     */
    public function getMetaDescription()
    {
        return (string)@$this->data['meta_description'];
    }

    /**
     * @param string $languageCode 2 letters country code
     * @return string
     */
    public function getMetaDescriptionForLanguage($languageCode = null)
    {
        if(!$languageCode) {
            $languageCode = _::languages()->getCurrent();
        }
        return (string)$this->data['meta_description'][$languageCode];
    }

    /**
     * @param array $value
     * @return \NetBricks\Page\Document\Page
     */
    public function setMetaTitle($value)
    {
        $this->data['meta_title'] = (array)$value;
        return $this;
    }

    /**
     * @return array
     */
    public function getMetaTitle()
    {
        return (array)@$this->data['meta_title'];
    }

    /**
     * @param string $languageCode 2 letters country code, if null then current language is used
     * @return string
     */
    public function getMetaTitleForLanguage($languageCode = null)
    {
        if(!$languageCode) {
            $languageCode = _::languages()->getCurrent();
        }
        return (string)@$this->data['meta_title'][$languageCode];
    }

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

    /**
     * @param array $value
     * @return \NetBricks\Page\Document\Page
     */
    public function setTitle($value)
    {
        $this->data['title'] = (array)$value;
        return $this;
    }

    /**
     * @return array
     */
    public function getTitle()
    {
        return (array)@$this->data['title'];
    }

    public function getTitleForLanguage($languageCode = null)
    {
        if(!$languageCode) {
            $languageCode = _::languages()->getCurrent();
        }
        return (string)@$this->data['title'][$languageCode];
    }

}
