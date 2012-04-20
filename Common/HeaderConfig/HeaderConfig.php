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

use \NetCore\DependencyInjection\ConfigurableContainer;
use \NetCore\Configurable\OptionsCollection;
use \NetBricks\Common\HeaderConfig\Title;
use \NetBricks\Common\HeaderConfig\ScriptsCollection;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 20.03.12
 * @time: 12:51
 */
class HeaderConfig extends ConfigurableContainer
{


    /** @var \NetBricks\Common\HeaderConfig\ScriptsCollection */
    private $scripts;

    /** @var \NetCore\Configurable\OptionsCollection */
    private $styleSheets;

    /** @var \NetBricks\Common\Component\Header\Title */
    private $title;

    /**
     * @return \NetBricks\Common\HeaderConfig\ScriptsCollection
     */
    public function getScripts()
    {
        if(!$this->scripts) {
            $this->scripts = new ScriptsCollection((array)@$this->options['scripts']);
        }
        return $this->scripts;
    }

    /**
     * @return \NetCore\Configurable\OptionsCollection
     */
    public function getStyleSheets()
    {
        if(!$this->styleSheets) {
            $this->styleSheets = new OptionsCollection((array)@$this->options['style_sheets']);
        }
        return $this->styleSheets;
    }

    /**
     * @return \NetBricks\Common\HeaderConfig\Title
     */
    public function getTitle()
    {
        if(!$this->title) {
            $this->title = new Title((string)@$this->options['title']);
        }
        return $this->title;
    }

    /**
     * @param string $value
     * @return \NetBricks\Common\HeaderConfig
     */
    public function setCharset($value)
    {
        $this->options['charset'] = (string)$value;
        return $this;
    }

    /**
     * @return string
     */
    public function getCharset()
    {
        return isset($this->options['charset']) ? $this->options['charset'] : 'utf-8';
    }

    /**
     * @param string $value
     * @return \NetBricks\Common\HeaderConfig
     */
    public function setRobots($value)
    {
        $this->options['robots'] = (string)$value;
        return $this;
    }

    /**
     * @return array
     */
    public function getScriptFiles()
    {
        return array_unique((array)@$this->options['script_files']);
    }

    /**
     * @return string
     */
    public function getRobots()
    {
        return isset($this->options['robots']) ? $this->options['robots'] : 'index, follow';
    }

    /**
     * @param string $value
     * @return \NetBricks\Common\HeaderConfig
     */
    public function setDescription($value)
    {
        $this->options['description'] = (string)$value;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return (string)@$this->options['description'];
    }

    /**
     * @param string $value
     * @return \NetBricks\Common\HeaderConfig
     */
    public function setKeywords($value)
    {
        $this->options['keywords'] = (string)$value;
        return $this;
    }

    /**
     * @return string
     */
    public function getKeywords()
    {
        return (string)@$this->options['keywords'];
    }

}
