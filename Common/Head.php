<?php

namespace NetBricks\Common;

use \NetBricks\Common\Tag;

/**
 * @author: Szymon Wygnański <s@finalclass.net>
 */
class Head extends Tag
{

    /**
     * @var \NetBricks\Common\Title
     */
    public $title;

    /**
     * @var \NetBricks\Common\HeadScripts
     */
    public $scripts;

    /**
     * @var \NetBricks\Common\HeadLinks
     */
    public $links;

    /**
     * @var \NetBricks\Common\HeadMeta
     */
    public $meta;

    protected $defaultAttributes = array();

    /**
     * @static
     * @param array $options
     * @return Head
     */
    static public function factory($options = array())
    {
        $class = get_called_class();
        return new $class($options);
    }

    public function preConstruct()
    {
        $this->title = Title::factory();
        $this->scripts = HeadScripts::factory();
        $this->links = HeadLinks::factory();
        $this->meta = HeadMeta::factory();

        $this->addChild($this->title)
            ->addChild($this->scripts)
            ->addChild($this->links)
            ->addChild($this->meta);
    }

    public function getTagName()
    {
        return 'head';
    }

}
