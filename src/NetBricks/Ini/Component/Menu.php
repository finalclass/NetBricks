<?php

/**
 * Menu
 *
 * Author: MMP
 */

namespace NetBricks\Ini\Component;

use \NetCore\Component\UnorderedList;
use \NetCore\Component\Event\ComponentEvent;
use \NetCore\Component\RelativeLink;

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