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

namespace NetBricks\Page\Component\Model;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 24.02.12
 * @time: 10:14
 */
class PageWidgetType
{

    protected $options = array();

    public function __construct()
    {
        $this->options['properties'] = array();
    }

    /**
     * @param string $value
     * @return \Drobgen\Page\Component\Model\WidgetType
     */
    public function setClass($value)
    {
        $this->options['class'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getClass()
    {
        return empty($this->options['class']) ? '' : $this->options['class'];
    }

    /**
     * @param string $value
     * @return \Drobgen\Page\Component\Model\WidgetType
     */
    public function setName($value)
    {
        $this->options['name'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return empty($this->options['name']) ? '' : $this->options['name'];
    }

    /**
     * @param $name
     * @param string $defaultValue
     * @return \Drobgen\Page\Component\Model\WidgetType
     */
    public function addProperty($name, $defaultValue = '')
    {
        $this->options['properties'][(string)$name] = (string)$defaultValue;
        return $this;
    }

    /**
     * @param array $array
     * @return \Drobgen\Page\Component\Model\WidgetType
     */
    public function addProperties(array $array)
    {
        $this->options['properties'] = array_merge($this->options['properties'], $array);
        return $this;
    }

    /**
     * @param $name
     * @return \Drobgen\Page\Component\Model\WidgetType
     */
    public function removeProperty($name)
    {
        unset($this->options['properties'][(string)$name]);
        return $this;
    }

    /**
     * @return array
     */
    public function getProperties()
    {
        return (array)$this->options['properties'];
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return (array)$this->options;
    }

    /**
     * @param array $array
     * @return \Drobgen\Page\Component\Model\WidgetType
     */
    public function fromArray(array $array)
    {
        $this->options = $array;
        return $this;
    }

}
