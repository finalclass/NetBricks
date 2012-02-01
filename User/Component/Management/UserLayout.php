<?php

namespace NetBricks\User\Component\Management;

use \NetBricks\User\Model\UserModel;
use \NetCore\Component\Container;
use \NetBricks\Common\ContentSwitcher;
use \NetCore\Component\RelativeLink;
use \NetBricks\Facade as _;

/**
 * UserLayout
 *
 * Author: MMP
 *
 * @property \NetBricks\Common\IconLink $addButton
 * @property \NetBricks\Common\IconLink $listButton
 * @property \NetCore\Component\ComponentAbstract $content
 */
class UserLayout extends Container
{

    public function __construct()
    {
        $f = _::loader('/NetBricks/Common/IconLink');
        $this->addButton = $f->create()->addParam('action', 'form')->setLabel('add new user');
        $this->listButton = $f->create()->addParam('action', 'list')->setLabel('list of users');

        switch(_::request()->getParam('action', 'list')) {
            case 'form':
                $this->content = _::loader('\NetBricks\User\Component\Management\UserForm')->create();
                break;
            default:
            case 'list':
                $this->content = _::loader('\NetBricks\User\Component\Management\UserList')->create();
                break;
            case 'erase':
                $this->content = _::loader('\NetBricks\User\Component\Management\UserEraser')->create();
                break;
        }
        parent::__construct();
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
    <?php echo $this->content; ?>;
    <?php
    }
}