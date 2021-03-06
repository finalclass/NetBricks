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
class TranslatorResource extends \Zend_Application_Resource_ResourceAbstract
{

    /**
     * @var string
     */
    protected $dir = array();

    protected function initConfig()
    {
        $configArray = $this->getOptions();
        $this->dir = str_replace(array('\\', '/'), DIRECTORY_SEPARATOR, (string)@$configArray['csv_dir']);
    }

    public function init()
    {
        $this->initConfig();
        $lang = _::languages()->getCurrent();
        $path = $this->dir . DIRECTORY_SEPARATOR . $lang . '.csv';

        if(!file_exists($path)) {
            $path = _::loader($this)->find('../Model/default_en.csv');
            $lang = 'en';
        }

        $translate = new \Zend_Translate(array(
            'adapter' => 'csv',
            'disableNotices' => false,
            'content' => $path,
            'locale' => $lang
        ));

        \Zend_Registry::set('Zend_Translate', $translate);
    }
}
