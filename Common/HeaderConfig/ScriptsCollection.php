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
use \NetBricks\Facade as _;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 20.04.12
 * @time: 09:29
 */
class ScriptsCollection extends OptionsCollection
{

    /**
     * @return \NetBricks\Common\HeaderConfig\ScriptsCollection
     */
    public function addJQuery()
    {
        return $this->set(-150, '/NetBricks/Common/js/jquery-1.7.2.min.js');
    }

    /**
     * @return \NetBricks\Common\HeaderConfig\ScriptsCollection
     */
    public function addKnockout()
    {
        $min = _::env()->isDevelopment ? '' : '.min';
        return $this->set(-149, '/NetBricks/Common/js/knockout-2.0.0' . $min . '.js');
    }

    /**
     * @return \NetBricks\Common\HeaderConfig\ScriptsCollection
     */
    public function addNetBricks()
    {
        return $this->addJQuery()
                ->set(-148, '/NetBricks/Common/js/netbricks-0.1.js');
    }

    /**
     * @param bool $includeDefaultStyleSheet
     * @return \NetBricks\Common\HeaderConfig\ScriptsCollection
     */
    public function addJQueryUi($includeDefaultStyleSheet = true)
    {
        if ($includeDefaultStyleSheet) {
            _::cfg()->getHeader()->getStyleSheets()->addJQueryWindow();
        }

        return $this->addJQuery()
                ->set(-147, '/NetBricks/Common/js/jquery-ui-1.8.19.min.js');
    }

    /**
     * @param bool $includeDefaultStyleSheet
     * @param null $jQueryUITheme
     * @return \NetBricks\Common\HeaderConfig\ScriptsCollection
     */
    public function addJQueryWindow($includeDefaultStyleSheet = true, $jQueryUITheme = null)
    {
        $src = _::env()->isDevelopment ? 'jquery.window.js' : 'jquery.window.min.js';

        if ($includeDefaultStyleSheet) {
            _::cfg()->getHeader()->getStyleSheets()->addJQueryWindow();
        }

        return $this->addJQueryUi($jQueryUITheme)
                ->set(-146, '/NetBricks/Common/js/jquery-window-5.03/' . $src);
    }

    /**
     * @return \NetBricks\Common\HeaderConfig\ScriptsCollection
     */
    public function addJQueryBBQ()
    {
        $suffix = _::env()->isDevelopment ? '.js' : '.min.js';
        return $this->addJQuery()
                ->set(-145, '/NetBricks/Common/js/jquery-bbq/jquery-bbq' . $suffix);
    }

    /**
     * @return \NetBricks\Common\HeaderConfig\ScriptsCollection
     */
    public function addJQueryTools()
    {
        return $this->addJQuery()
                ->set(-144, '/NetBricks/Common/js/jquery.tools.min.js');
    }

    public function addJQueryBlink()
    {
        return $this->addJQuery()
            ->set(-143, '/NetBricks/Common/js/jquery.blink.js');
    }

    public function addBrickAutoloader()
    {
        return $this->addJQuery()
                ->addNetBricks()
                ->set(-142, '/NetBricks/Common/js/jquery-brick_autoloader-v0.0.1.js');
    }

}