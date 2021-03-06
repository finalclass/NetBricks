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

namespace NetBricks\Page;

use \NetCore\Configurable\OptionsAbstract;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 04.03.12
 * @time: 15:29
 */
class Config extends OptionsAbstract
{

    /**
     * @var \NetBricks\Page\Config\Photo
     */
    private $photo;

    /** @var \NetBricks\Page\Config\Widget */
    private $widget;

    /**
     * @return Config\Photo
     */
    public function getPhoto()
    {
        if (!$this->photo) {
            $this->photo = new \NetBricks\Page\Config\Photo((array)@$this->options['photo']);
        }
        return $this->photo;
    }

    /**
     * @return \NetBricks\Page\Config\Widget
     */
    public function getWidget()
    {
        if(!$this->widget) {
            $this->widget = new \NetBricks\Page\Config\Widget((array)@$this->options['widget']);
        }
        return $this->widget;
    }

}
