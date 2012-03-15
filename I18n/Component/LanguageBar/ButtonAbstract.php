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

namespace NetBricks\I18n\Component\LanguageBar;

use \NetBricks\Common\Component\ComponentAbstract;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 15.03.12
 * @time: 11:53
 */
class ButtonAbstract extends ComponentAbstract
{

    public function __construct($options = array())
    {
        parent::__construct($options);
        $this->addCSS('nb_i18n_language_bar_button_abstract', array($this, 'getCSS'));
    }

    static public function getCSS()
    {
        ?>
    <style type="text/css">
        .nb_i18n_language_bar_button_abstract {
            width: 14px;
            height: 7px;
            background-color: #00f;

            -webkit-border-radius: 2px;
            -moz-border-radius: 2px;
            border-radius: 2px;
        }

        .nb_i18n_language_bar_button_abstract:hover {
            background-color: #8b0000;
            cursor: pointer;
        }
    </style>
    <?php
    }

}
