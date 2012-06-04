<?php
/**
 * Created by JetBrains PhpStorm.
 * User: sel
 * Date: 04.06.12
 * Time: 10:07
 * To change this template use File | Settings | File Templates.
 */

namespace NetBricks\Newsletter\Component;

use \NetBricks\Common\Component\Tag;
use \NetBricks\Common\Component\BasicCrud\Menu;

/**
 * @property \NetBricks\Common\Component\BasicCrud\Menu $menu
 */
class Management extends Tag
{

    public function __construct($options = array())
    {
        $this->menu = new Menu();

        parent::__construct($options);
    }

}
