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

namespace NetBricks;

use \NetCore\DependencyInjection\ConfigurableContainer;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 28.02.12
 * @time: 10:31
 */
class Config extends ConfigurableContainer
{

    /** @var \NetCore\CouchDB\Config */
    private $couchdb;

    /** @var \NetBricks\Page\Config */
    private $page;

    /** @var \NetBricks\Common\HeaderConfig */
    private $header;

    /** @return \NetCore\CouchDB\Config */
    public function getCouchdb()
    {
        if (!$this->couchdb) {
            $this->couchdb = new \NetCore\CouchDB\Config((array)@$this->options['doctrine']);
        }
        return $this->couchdb;
    }

    /** @return \NetBricks\Page\Config */
    public function getPage()
    {
        if (!$this->page) {
            $this->page = new \NetBricks\Page\Config((array)@$this->options['page']);
        }
        return $this->page;
    }

    /**
     * @param string $value
     * @return \NetBricks\Page\Config\Photo
     */
    public function setTempDir($value)
    {
        $this->options['temp_dir'] = (string)$value;
        return $this;
    }

    /**
     * @return string
     */
    public function getTempDir()
    {
        return (string)@$this->options['temp_dir'];
    }

    /**
     * @return \NetBricks\Common\HeaderConfig
     */
    public function getHeader()
    {
        if(!$this->header) {
            $this->header = new \NetBricks\Common\HeaderConfig((array)@$this->options['header']);
        }
        return $this->header;
    }

}
