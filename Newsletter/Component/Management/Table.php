<?php
/**
 * Created by JetBrains PhpStorm.
 * User: sel
 * Date: 04.06.12
 * Time: 09:49
 * To change this template use File | Settings | File Templates.
 */

namespace NetBricks\Newsletter\Component\Management;

use \NetBricks\Common\Component\Table as BaseTable;
use \NetBricks\Facade;
use \NetBricks\Common\Component\Extended\Renderer\Operations;

class Table extends BaseTable
{

    public function __construct($params = array())
    {

        $optionsRenderer = Operations::factory()
            ->setStateParam('nb_newsletter_management')
            ->setServiceName('nb_newsletter_user');

        $this->column('email', 'E-mail')
            ->column('operations', 'Operations', $optionsRenderer);

        parent::__construct($params);
    }

}
