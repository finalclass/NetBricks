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

namespace NetBricks\Common\Component\Header;

use \NetBricks\Common\Component\Container;
use \NetBricks\Facade as _;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 30.01.12
 * @time: 10:09
 */
class Scripts extends Container
{

    protected $scriptFiles = array();
    protected $scripts = array();
    protected $addedScriptsNames = array();
    protected $componentScripts = array();

    protected function beforeRender()
    {
        foreach ($this->scriptFiles as $file) {
            $this->addChild($file);
        }

        $this->addComponentScripts();

        foreach ($this->scripts as $type => $contentArray) {
            $this->addChild(Script::factory()->setType($type)->setContent(join(PHP_EOL, $contentArray)));
        }
    }

    private function addComponentScripts()
    {
        $addedClasses = array();
        foreach($this->componentScripts as $fullClassName) {
            if(isset($addedClasses[$fullClassName])) {
                continue;
            }
            $exploded = explode('\\', $fullClassName);
            $className = end($exploded);
            $className = ucfirst($className);
            $fileName = $className . '.js';
            $exploded[count($exploded)] = $fileName;
            $path = join(DIRECTORY_SEPARATOR, $exploded);
            $this->addChild(_::loader($path)->getPath());
            $addedClasses[$fullClassName] = true;
        }
    }

    public function appendScriptFile($src, $ieMaxVersion = null, $type = 'text/javascript')
    {
        $this->scriptFiles[] = Script::factory()->setSrc($src)->setIEMaxVersion($ieMaxVersion)->setType($type);
        return $this;
    }

    public function prependScriptFile($src, $ieMaxVersion = null, $type = 'text/javascript')
    {
        array_unshift($this->scriptFiles,
            Script::factory()->setSrc($src)->setIEMaxVersion($ieMaxVersion)->setType($type));
    }

    public function appendScript($scriptContent, $type = 'text/javascript', $name = null)
    {
        if (!isset($this->scripts[$type])) {
            $this->scripts[$type] = array();
        }
        //$this->scripts[$type][] = \NetCore\Renderer::removeTag('script', $scriptContent);
        if ($name) {
            $this->addedScriptsNames[$name] = true;
        }
        return $this;
    }

    public function hasScript($name)
    {
        return isset($this->addedScriptsNames[(string)$name]);
    }

    public function prependScript($scriptContent, $type = 'text/javascript', $name)
    {
        if (!isset($this->scripts[$type])) {
            $this->scripts[$type] = array();
        }
        array_unshift($this->scripts[$type], \NetCore\Renderer::removeTag('script', $scriptContent));
        if ($name) {
            $this->addedScriptsNames[$name] = true;
        }
        return $this;
    }

    public function appendComponentScript($componentClassName)
    {
        $this->componentScripts[] = $componentClassName;
    }

    public function prependComponentScript($componentClassName)
    {
        array_unshift($this->componentScripts, $componentClassName);
    }

    public function hasComponentScript($componentClassName)
    {
        foreach($this->componentScripts as $className) {
            if($componentClassName == $className) {
                return true;
            }
        }
        return false;
    }

    public function removeComponentScript($componentClassName)
    {
        $count = count($this->componentScripts);
        for($i = 0; $i < $count; $i++) {
            $cmp = $this->componentScripts[$i];
            if($cmp == $componentClassName) {
                unset($this->componentScripts[$i]);
            }
        }
    }

}
