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

namespace NetBricks\Common;

use \NetBricks\Common\Container;
use \NetBricks\Facade as _;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 01.03.12
 * @time: 14:15
 *
 * @property \NetBricks\Common\Header\Keywords $keywords
 * @property \NetBricks\Common\Header\StyleSheets $styleSheets
 * @property \NetBricks\Common\Header\Scripts $scripts
 * @property \NetBricks\Common\Header\Title $title
 */
class Header extends Container
{

    public function __construct($options = array())
    {
        $this->keywords     = _::loader($this)->find('Keywords')->create();
        $this->styleSheets  = _::loader($this)->find('StyleSheets')->create();
        $this->scripts      = _::loader($this)->find('Scripts')->create();
        $this->title        = _::loader($this)->find('Title')->create();
        parent::__construct($options);
    }

    /**
     * @param string $value
     * @return \NetBricks\Common\Header
     */
    public function setMetaDescription($value)
    {
        $this->options['meta_description'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getMetaDescription()
    {
        return empty($this->options['meta_description']) ? '' : $this->options['meta_description'];
    }

    /**
     * @param string $value
     * @return \NetBricks\Common\Header
     */
    public function setFavicon($value)
    {
        $this->options['favicon'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getFavicon()
    {
        return empty($this->options['favicon']) ? 'favicon.ico' : $this->options['favicon'];
    }

    public function render()
    {
        ?>
    <head>
        <?php echo $this->title; ?>
        <?php echo $this->keywords; ?>
        <meta name="description" content="<?php echo $this->getMetaDescription(); ?>">
        <meta charset="utf-8"/>
        <link rel="icon" href="<?php echo $this->getFavicon(); ?>"/>
        <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
        <?php echo $this->styleSheets; ?>
        <?php echo $this->scripts; ?>
    </head>
    <?php
    }

}
