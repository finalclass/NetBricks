<?php

namespace NetBricks\Event;

use \NetCore\Event\Event;

/**
 * Author: Sel <s@finalclass.net>
 * Date: 22.11.11
 * Time: 11:52
 */
class BootstrapEvent extends Event
{

    const LAYOUT_BEFORE_CONSTRUCTION = 'layout_before_construction';
    const LAYOUT_AFTER_CONSTRUCTION = 'layout_after_construction';
    const LAYOUT_BEFORE_RENDER = 'layout_before_render';
    const LAYOUT_AFTER_RENDER = 'layout_after_render';

    public function __construct($name)
    {
        parent::__construct($name);
    }

}
