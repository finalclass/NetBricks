<?php

namespace NetBricks\Common\ContentSwitcher;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 17.11.11
 * @time: 09:59
 */
class SwitcherCase
{

    /**
     * @var string
     */
    private $caseName;

    /**
     * @var string
     */
    private $contentClassName;

    /**
     * @param string $caseName
     * @param string $contentClassName
     */
    public function __construct($caseName, $contentClassName)
    {
        $this->caseName = $caseName;
        $this->contentClassName = $contentClassName;
    }

    /**
     * @return string
     */
    public function getCaseName()
    {
        return $this->caseName;
    }

    /**
     * @return string
     */
    public function getContentClassName()
    {
        return $this->contentClassName;
    }

}
