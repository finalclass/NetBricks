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

namespace NetBricks\I18n\Model;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 22.02.12
 * @time: 15:15
 */
class Languages
{

    private $options = array();


    public function __construct($options = array())
    {

        $this->setAvailable((array)@$options['available'])
             ->setDefault((string)@$options['default'])
             ->setCurrent((string)@$options['current']);
    }


    /**
     * @param \NetBricks\I18n\Model\Language[] $languages
     * @return \NetBricks\I18n\Model\Languages
     */
    public function setAvailable(array $languages)
    {
        $available = array();
        foreach($languages as $lang) {
            if( !($lang instanceof Language) ) {
                $langModel = new Language($lang);
            } else {
                $langModel = $lang;
            }
            $available[$langModel->getCode()] = $langModel;
        }
        $this->options['available'] = (array)$available;
        return $this;
    }

    public function hasLanguage($languageCode)
    {
        return isset($this->options['available'][$languageCode]);
    }

    /**
     * @return \NetBricks\I18n\Model\Language[]
     */
    public function getAvailable()
    {
        return empty($this->options['available']) ? array() : $this->options['available'];
    }

    public function getAvailableLanguageCodes()
    {
        return array_keys($this->options['available']);
    }

    /**
     * 2 letters - country code
     *
     * @param string $value
     * @return \NetBricks\I18n\Model\Languages
     */
    public function setDefault($value)
    {
        $this->options['default'] = substr((string)$value, 0, 2);
        return $this;
    }

    /**
     * @return string
     */
    public function getDefault()
    {
        return empty($this->options['default']) ? '' : $this->options['default'];
    }

    /**
     * @param string $value 2 letters country code
     * @return \NetBricks\I18n\Model\Languages
     */
    public function setCurrent($value)
    {
        $this->options['current'] = substr((string)$value, 0, 2);
        return $this;
    }

    /**
     * @return string
     */
    public function getCurrent()
    {
        return empty($this->options['current']) ? '' : $this->options['current'];
    }

    /**
     * @param string $code 2 letters country code
     * @return Language|null
     */
    public function findByCode($code)
    {
        $code = (string)$code;
        $available = $this->getAvailable();
        return isset($available[$code]) ? $available[$code] : null;
    }

}
