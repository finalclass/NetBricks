<?php

namespace NetBricks\User\Component\Management;

use \NetBricks\User\Model\UserModel;
use \NetBricks\Common\Component\Tag;
use \NetBricks\Common\Component\ContentSwitcher;
use \NetBricks\Common\Component\RelativeLink;
use \NetBricks\Facade as _;

/**
 * UserLayout
 *
 * Author: MMP
 *
 * @property \NetBricks\Common\Component\IconLink $addButton
 * @property \NetBricks\Common\Component\IconLink $listButton
 * @property \NetBricks\Common\Component\ComponentAbstract $content
 */
class UserLayout extends Tag
{

    public function __construct()
    {
        $f = _::loader('/NetBricks/Common/Component/IconLink');
        $this->addButton = $f->create()->addParam('action', 'form')->setLabel('add new user');
        $this->listButton = $f->create()->addParam('action', 'list')->setLabel('list of users');
        _::cfg()->getHeader()->getStyleSheets()->addNetBricks();
        $this->addClass('nb_user_management_layout');

        switch (_::request()->getParam('action', 'list')) {
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
    <div <?php echo $this->renderTagAttributes($this->getDefaultAttributes()); ?>>
    <h2>Users</h2>
    <ul class="buttons">
        <li>
            <?php echo $this->addButton->setIconClass('ui-icon ui-icon-plus')
                ->addClass('ui-state-default ui-corner-all nb-button'); ?>
        </li>
        <li>
            <?php echo $this->listButton->setIconClass('ui-icon ui-icon-folder-open')
                ->addClass('ui-state-default ui-corner-all nb-button'); ?>
        </li>
    </ul>
    <?php echo $this->content; ?>
    </div>
    <?php
    }
}