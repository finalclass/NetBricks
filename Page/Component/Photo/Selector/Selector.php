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

namespace NetBricks\Page\Component\Photo;

use \NetBricks\Common\Component\Extended\ComboBox;
use \NetBricks\Page\Component\Photo\Selector\PhotoRenderer;
use \NetBricks\Page\Document\Photo\Repository;
use \NetBricks\Common\Component\Container;
use \NetBricks\Facade as _;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 19.03.12
 * @time: 10:35
 *
 * @property \NetBricks\Common\Component\Extended\ComboBox $comboBox
 */
class Selector extends Container
{

    public function __construct($options = array())
    {
        $this->comboBox = _::loader('\NetBricks\Common\Component\Extended\ComboBox')->create();
        $this->comboBox->renderer = new PhotoRenderer();
        $this->comboBox->setDataProvider($this->getRepo()->all());
        $this->addCSS('nb_page_photo_selector', array($this, 'getSelectorCSS'));
        $this->addJS('nb_page_photo_selector', array($this, 'getSelectorJS'));
        parent::__construct($options);
    }

    public function getSelectorJS()
    {
        return file_get_contents(_::loader(__CLASS__ . '/selector.js')->getFullPath());
    }

    public function getSelectorCSS()
    {
        $height = _::cfg()->getPage()->getPhoto()->getThumbHeight();
        ?>
    <style type="text/css">
        .nb_page_photo_selector .nb_extended_combo_box {
            height: <?php echo $height . 'px'; ?>,
        }
        .nb_page_photo_selector .nb_extended_combo_box {
            height: <?php echo $height+4 . 'px'; ?>
        }
        .nb_page_photo_selector img:hover {
            opacity: 0.7;
        }
    </style>
        <?php
    }

    public function render()
    {
        ?>
            <div class="nb_page_photo_selector">
                <?php echo $this->comboBox; ?>
            </div>
        <?php
    }

    public function getRepo()
    {
        static $repo;
        if(!$repo) {
            $repo = new Repository();
        }
        return $repo;
    }

}
