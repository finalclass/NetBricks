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

namespace NetBricks\Common\Document;

use \NetCore\CouchDB\Document;

use \NetBricks\Facade as _;

use \NetBricks\I18n\Exception\UnavailableLanguageSpecified;;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 08.03.12
 * @time: 10:12
 */
class MultiLangDocument extends Document
{

    /**
     * @var string 2 letters - language code (example pl, en, ru, fr, ...)
     */
    private $currentLanguage = null;

    public function setLanguage($languageCode)
    {
        if(!_::languages()->hasLanguage($languageCode)) {
            throw new UnavailableLanguageSpecified('Language ' . $languageCode . ' is not available');
        }
        $this->currentLanguage = $languageCode;
        return $this;
    }

    public function getLanguage()
    {
        if(!$this->currentLanguage) {
            $this->currentLanguage = _::languages()->getCurrent();
        }
        return $this->currentLanguage;
    }

    protected function filterTranslations(array $translations)
    {
        $languages = $this->getAllLanguages();
        $filtered = array();
        foreach($languages as $code) {
            $filtered[$code] = @$translations[$code];
        }
        return $filtered;
    }

    /**
     * @return array array of available language codes
     */
    protected function getAllLanguages()
    {
        return _::languages()->getAvailableLanguageCodes();
    }

}
