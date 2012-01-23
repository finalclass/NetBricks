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

    }
}