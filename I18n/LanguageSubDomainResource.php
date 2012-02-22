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

namespace NetBricks\I18n;

use \NetBricks\Facade as _;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 07.02.12
 * @time: 14:27
 *
 * This resource should be run after setting router
 */
class LanguageSubDomainResource extends \Zend_Application_Resource_ResourceAbstract
{

    protected $availableLanguages = array();
    protected $defaultLanguage = '';
    protected $topLevelDomain = '';
    protected $secondLevelDomain = '';
    protected $domainPrefix = '';

    protected function initConfig()
    {
        $configArray = $this->getOptions();
        $this->availableLanguages = (array)@$configArray['available_languages'];
        $this->defaultLanguage = (string)@$configArray['default_language'];
        $this->topLevelDomain = (string)@$configArray['top_level_domain'];
        $this->secondLevelDomain = (string)@$configArray['second_level_domain'];
        $this->domainPrefix = (string)@$configArray['domain_prefix'];
    }

    public function init()
    {
        $this->initConfig();
        $lang = $this->findLanguageFromUri();
        if($lang) {
            _::request()->lang = $lang;
        } else {
            $this->repairUrl($this->secondLevelDomain, _::request()->getHost(), $this->topLevelDomain);
        }
    }

    public function findLanguageFromUri()
    {
        $siteName = $this->secondLevelDomain;
        $suffix = $this->topLevelDomain;
        $host = _::request()->getHost();

        foreach($this->availableLanguages as $lang) {
            $langWithDot = $lang == $this->defaultLanguage ? '' : $lang . '.';
            $prefix = empty($this->domainPrefix) ? '' : $this->domainPrefix . '.';
            if($host == $prefix . $langWithDot . $siteName . '.' . $suffix) {
                return $lang;
            }
        }
        return null;
    }

    protected function repairUrl($siteName, $host, $suffix)
    {
        //find out the current language
        //switch to "with $this->domainPrefix" version (domainPrefix usually is "www")
        $matches = array();
        preg_match('#(.{2})\.' . $siteName . '\..*#', $host, $matches);

        if (empty($matches) || empty($matches[1])) {
            $lang = $this->defaultLanguage;
        } else {
            if (!array_search($matches[1], $this->availableLanguages)) {
                $lang = $this->defaultLanguage;
            }
        }
        if (!isset($lang)) {
            $lang = $matches[1];
        }

        //Now as we got correct $lang we can redirect
        $lang = $lang == $this->defaultLanguage ? '' : $lang;
        $prefix = empty($this->domainPrefix) ? '' : $this->domainPrefix . '.';
        $this->redirectToCorrectUrl($lang, $siteName, $suffix, $prefix);
    }

    protected function redirectToCorrectUrl($lang, $siteName, $suffix, $prefix = '')
    {
        if(!empty($lang)) {
            $lang = $lang . '.';
        }
        $protocol = (@$_SERVER['HTTPS'] == 'on') ? 'https://' : 'http://';
        $baseUrl = $prefix . $lang . $siteName . '.' . $suffix;
        if ($_SERVER['SERVER_PORT'] != '80') {
            $port = ':' . $_SERVER['SERVER_PORT'];
        } else {
            $port = '';
        }

        $url = $protocol . $baseUrl . $port;

        if ($url[strlen($url) - 1] == '/') {
            $url = substr($url, 0, strlen($url) - 1);
        }

        header('HTTP/1.1 301 Moved Permanently');
        header('Location: ' . $url . $_SERVER['REQUEST_URI']);
    }

}
