<?php

namespace NetBricks\User\Component\Management;

use \NetBricks\Common\ComponentAbstract;
use \NetBricks\User\Model\UserModel;
use \NetBricks\Facade as _;

/**
 * UserEraser
 *
 * Author: MMP
 */
class UserEraser extends ComponentAbstract {

    public $user;

    public function __construct() {

//        $user = new UserModel;
//        $email = $user->getEmail();
//        $password = $user->getPassword();
//        $user = UserModel::findByEmailAndPassword($email, $password);

        $user = UserModel::find(_::request()->user);
        if ($user != null)
            $user->delete();
        header('Location: /admin/users/list');
    }

}