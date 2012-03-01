<?php

namespace NetBricks\Common\Exception;

use \NetBricks\Common\Exception as ComponentException;

/**
 * Author: Sel <s@finalclass.net>
 * Date: 05.12.11
 * Time: 14:26
 */
class NotAComponent
    extends \InvalidArgumentException
    implements ComponentException
{

}
