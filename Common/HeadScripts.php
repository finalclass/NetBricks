<?php

namespace NetBricks\Common;

use \NetBricks\Common\Tag;

/**
 * Author: Szymon Wygnański
 * Date: 12.09.11
 * Time: 00:41
 */
class HeadScripts extends Tag
{

    private $scriptFiles = array();

    private $userScript = '';

    public function preConstruct()
    {
        $scriptFiles = $this->scriptFiles;
        $userScript = $this->userScript;
    }

    public function render()
    {
        foreach($this->scriptFiles as $file) {
            echo '<script type="text/javascript" src="' . $file . '" ></script>';
        }

        if(!empty($this->userScript)) {
            echo '<script type="text/javascript">' . PHP_EOL . $this->userScript . PHP_EOL . '</script>';
        }
    }

    public function appendScript($script)
    {
        $this->userScript .= PHP_EOL . $script;
        return $this;
    }

    public function appendFile($path)
    {
        $this->scriptFiles[] = $path;
        return $this;
    }

    public function getTagName()
    {
        return 'script';
    }

}
