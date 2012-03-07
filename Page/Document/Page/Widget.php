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

namespace NetBricks\Page\Document\Page;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 07.03.12
 * @time: 08:26
 */
class Widget
{

    protected $data = array(
        'type' => '\NetBricks\Common\Component\Container',
        'configuration' => array()
    );

    public function __construct(&$data = array())
    {
        $this->setData($data);
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param array $data
     * @return \NetBricks\Page\Document\Page\Widget
     */
    public function setData(array &$data)
    {
        $this->data = &$data;
        if (!isset($this->data['type'])) {
            $this->data['type'] = '\NetBricks\Common\Component\Container';
        }
        if (!isset($this->data['configuration'])) {
            $this->data['configuration'] = array();
        }
        return $this;
    }

    /**
     * @param string $value
     * @return \NetBricks\Page\Document\Page\Widget
     */
    public function setType($value)
    {
        $this->data['type'] = (string)$value;
        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return (string)@$this->data['type'];
    }

    /**
     * @param array $value
     * @return \NetBricks\Page\Document\Page\Widget
     */
    public function setConfiguration($value)
    {
        $this->data['configuration'] = (array)$value;
        return $this;
    }

    /**
     * @return array
     */
    public function getConfiguration()
    {
        return (array)@$this->data['configuration'];
    }

}
