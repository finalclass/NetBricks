<?php

namespace NetBricks\User\Component\Management;

use \NetBricks\User\Model\UserModel;
use \NetCore\Component\Container;
use \NetBricks\Common\ContentSwitcher\ContentSwitcher;
use \NetCore\Component\RelativeLink;
use \NetBricks\Facade as _;

/**
 * UserLayout
 *
 * Author: MMP
 *
 * @property \NetBricks\Common\IconLink $addButton
 * @property \NetBricks\Common\IconLink $listButton
 * @property \NetBricks\Common\ContentSwitcher $contentSwitcher
 */
class UserLayout extends Container
{

    public function __construct()
    {

        parent::__construct();

        $f = _::factory()->netBricks->common;

        $this->addButton = $f->iconLink()->addParam('action', 'form')->setLabel('add new user');
        $this->listButton = $f->iconLink()->addParam('action', 'list')->setLabel('list of users');

        $this->contentSwitcher = $f->contentSwitcher->contentSwitcher()
                ->addCase('form', '\NetBricks\User\Component\Management\UserForm')
                ->addCase('list', '\NetBricks\User\Component\Management\UserList')
                ->addCase('erase', '\NetBricks\User\Component\Management\UserEraser')
                ->setDefaultCaseName('list')
                ->switchTo(_::request()->getParam('action', 'list'));
    }

    public function render()
    {
        ?>
    <h2>Users</h2>
    <ul class="buttons">
        <li>
            <?php echo $this->addButton->setIconClass('ui-icon ui-icon-plus'); ?>
        </li>
        <li>
            <?php echo $this->listButton->setIconClass('ui-icon ui-icon-folder-open'); ?>
        </li>
    </ul>
    <?php echo $this->contentSwitcher; ?>;
    <?php
    }
}