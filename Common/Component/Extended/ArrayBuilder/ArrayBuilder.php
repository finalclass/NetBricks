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
namespace NetBricks\Common\Component\Extended;

use \NetBricks\Common\Component\Form\FormElementAbstract;
use \NetBricks\Facade as _;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 19.04.12
 * @time: 09:39
 */
class ArrayBuilder extends FormElementAbstract
{

    protected $defaultAttributes = array('id', 'class', 'style');

    public function __construct($options = array())
    {
        parent::__construct($options);
        $this->addClass('nb_extended_array_builder');
        _::cfg()->getHeader()->getScripts()
                ->addNetBricks()
                ->addKnockout();

        _::cfg()->getHeader()->getStyleSheets()->addNetBricks();
    }

    public function setValue($value)
    {
        $value = array_filter($value);
        parent::setValue($value);
        return $this;
    }

    public function getValue()
    {
        return @(array)parent::getValue();
    }

    public function render()
    {
        include _::loader(__CLASS__)->find('arrayBuilder.phtml')->getFullPath();
    }

}
