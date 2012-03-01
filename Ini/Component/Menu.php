<?php

/**
 * Menu
 *
 * Author: MMP
 */

namespace NetBricks\Ini\Component;

use \NetBricks\Common\UnorderedList;
use \NetBricks\Common\Event\ComponentEvent;
use \NetBricks\Common\RelativeLink;

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