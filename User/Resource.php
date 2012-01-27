<?php

namespace NetBricks\User;

use \NetBricks\User\Model\UserModel;
use \NetBricks\Facade as _;

/**
 * Resource for UserModel
 *
 * Author: MMP
 */
class Resource extends \Zend_Application_Resource_ResourceAbstract {

    public function init() {

        $cnf = $this->getOptions();

        if(!empty($cnf['users_dir'])) {
            UserModel::setDir($cnf['users_dir']);
        }

        _::services()->login->setNamespace('\NetBricks\User\Service\Login');

        _::stage()->addCase('login', '\NetBricks\User\Component\Login\LoginPage')
                ->addCase('logout', '\NetBricks\User\Component\Login\Logout');

        _::router()->addRoute('login', 'login', array('stage' => 'login'))
                ->addRoute('logout', 'logout', array('stage' => 'logout'));
    }
}