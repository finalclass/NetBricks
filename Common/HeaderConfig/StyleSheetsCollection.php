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
namespace NetBricks\Common\HeaderConfig;
use \NetCore\Configurable\OptionsCollection;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 20.04.12
 * @time: 12:26
 */
class StyleSheetsCollection extends OptionsCollection
{

    /**
     * @param string $value
     * @return \NetBricks\Common\HeaderConfig\StyleSheetsCollection
     */
    public function setDefaultJqueryUiTheme($value)
    {
        $this->options['default_jquery_ui_theme'] = (string)$value;
        return $this;
    }

    /**
     * @return string
     */
    public function getDefaultJqueryUiTheme()
    {
        return isset($this->options['default_jquery_ui_theme'])
                ? $this->options['default_jquery_ui_theme'] : 'dark-hive';
    }

    /**
     * @param null $theme
     * @return \NetBricks\Common\HeaderConfig\StyleSheetsCollection
     */
    public function addJQueryUi($theme = null)
    {
        if (!$theme) {
            $theme = $this->getDefaultJqueryUiTheme();
        }
        return $this->append('/NetBricks/Common/css/' . $theme . '/jquery-ui.css');
    }

    /**
     * @param null $theme
     * @return \NetBricks\Common\HeaderConfig\StyleSheetsCollection
     */
    public function addNetBricks($theme = null)
    {
        return $this->addJQueryUi($theme)
                ->append('/NetBricks/Common/css/netbricks.css');
    }

    /**
     * @return \NetBricks\Common\HeaderConfig\StyleSheetsCollection
     */
    public function addJQueryWindow()
    {
        return $this->addJQueryUi()
                ->append('/NetBricks/Common/js/jquery-window-5.03/css/jquery.window.css');
    }

}
