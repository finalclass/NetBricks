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

namespace NetBricks\Common\Component\BasicCrud;

use \NetBricks\Common\Component\UnorderedList;
use \NetBricks\Common\Component\IconLink;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 02.03.12
 * @time: 09:17
 *
 * @property \NetBricks\Common\Component\IconLink $addButton
 * @property \NetBricks\Common\Component\IconLink $listButton
 */
class Menu extends UnorderedList
{

    /**
     * @static
     * @param array $options
     * @return Menu
     */
    public static function factory($options = array())
    {
        $class = get_called_class();
        return new $class($options);
    }

    public function __construct($options = array())
    {
        if (!isset($options['param_to_switch'])) {
            $options['param_to_switch'] = 'action';
        }

        $this->setClass('buttons');

        $this->addButton = IconLink::factory()
                ->setIconClass('plus')
                ->setLabel('Add')
                ->addParam('id', '');

        $this->listButton = IconLink::factory()
                ->setIconClass('list')
                ->setLabel('List');

        parent::__construct($options);
    }

    public function beforeRender()
    {
        $this->addButton->addParam($this->getParamToSwitch(), 'add');
        $this->listButton->addParam($this->getParamToSwitch(), 'list');
    }

    /**
     * @param string $value
     * @return \NetBricks\Common\Component\BasicCrud\Menu
     */
    public function setParamToSwitch($value)
    {
        $this->options['param_to_switch'] = (string)$value;
        return $this;
    }

    /**
     * @return string
     */
    public function getParamToSwitch()
    {
        return (string)@$this->options['param_to_switch'];
    }

}
