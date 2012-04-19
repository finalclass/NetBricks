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

namespace NetBricks\Page\Component\Widget;

use \NetBricks\Common\Component\Tag;
use \NetBricks\Facade as _;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 15.03.12
 * @time: 14:08
 */
class Management extends Tag
{

    public function __construct($options = array())
    {
        parent::__construct($options);
        _::cfg()->getHeader()->getScripts()
                ->prepend('/NetBricks/Common/js/nb.js')
                ->prepend('/NetBricks/Common/js/jquery.js')
                ->append(_::loader(__CLASS__ . '/../widget.js')->getPath());

        $this->setClass($this->getClass() . ' nb_page_widget_management'    );
    }

    public function render()
    {
        include _::loader($this)->find('management.phtml')->getFullPath();
    }

    public function renderDefaultAttributes()
    {
        return $this->renderTagAttributes(array('class', 'id', 'style'));
    }

    /**
     * @param array $value
     * @return \NetBricks\Page\Component\Widget\Management
     */
    public function setDataProvider($value)
    {
        $this->options['data_provider'] = (array)$value;
        return $this;
    }

    /**
     * @return array
     */
    public function getDataProvider()
    {
        return (array)@$this->options['data_provider'];
    }

    public function createWidget($type)
    {
        if (is_subclass_of($type, '\NetBricks\Common\Component\ComponentAbstract')) {
            return _::loader($type)->create();
        } else {
            throw new \NetBricks\Common\Component\Exception\NotAComponent('Widget is supposed to be a component');
        }

    }

}