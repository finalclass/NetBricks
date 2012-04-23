<?php

namespace NetBricks\User\Component\Management;

use \NetBricks\Common\Component\Container;
use \NetCore\FileSystem\Model;
use \NetBricks\User\Model\UserModel;
use \NetBricks\Common\Component\Table;
use \NetBricks\Facade as _;
use \NetBricks\Common\Component\UnorderedList;

/**
 * UserList
 *
 * Author: MMP
 */
class UserList extends Table
{

    protected $array = array();

    public function __construct()
    {

        parent::__construct();
        $this->array = UserModel::findAll();
        $this->setDataProvider(UserModel::findAll())
                ->column('email', 'E-mail')
                ->column('operations', 'Operacje', array($this, 'renderOperations'))
                ->setClass('grid');

    }

    public function renderOperations(Table $table, UserModel $user)
    {
        /**
         * @var \NetCore\Factory\Factory $linkFactory
         * @var \NetBricks\Common\Component\IconLink $editLink
         * @var \NetBricks\Common\Component\IconLink $removeLink
         */
        $linkFactory = _::factory()->netBricks->common->component->iconLink;

        $editLink = $linkFactory()
                ->setIconClass('ui-icon ui-icon-wrench')
                ->addParam('action', 'form')
                ->addParam('user_id', $user->getId())
                ->setLabel('Edytuj');

        $removeLink = $linkFactory()
                ->setIconClass('ui-icon ui-icon-trash')
                ->addParam('action', 'erase')
                ->addParam('user_id', $user->getId())
                ->setOnclick("return confirm('Czy jesteś pewien?');")
                ->setLabel('Usuń');

        return UnorderedList::factory()
                ->setClass('operations')
                ->addChild($editLink)
                ->addChild($removeLink);
    }
}