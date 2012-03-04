<?php

/**
 * Menu
 *
 * Author: MMP
 */

namespace NetBricks\Ini\Component;

use \NetBricks\Common\Component\UnorderedList;
use \NetBricks\Common\Component\Event\ComponentEvent;
use \NetBricks\Common\Component\RelativeLink;

class Menu extends UnorderedList {

    public function __construct() {
        $this->initItems();
        parent::__construct();
    }

    private function initItems() {
        $this->addChild(
                RelativeLink::factory()
                        ->select('config')
                        ->setContent('Konfiguracja'));
    }

}