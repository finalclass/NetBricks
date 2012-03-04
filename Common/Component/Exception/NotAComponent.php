<?php

namespace NetBricks\Common\Component\Exception;

use \NetBricks\Common\Component\Exception as ComponentException;

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
