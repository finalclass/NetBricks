<?php

namespace NetBricks\User\Component\Login;
use \NetBricks\User\Model\CurrentUser;
use \NetCore\Component\ComponentAbstract;
use \NetBricks\Facade as _;

/**
 * Logout
 *
 * Author: MMP
 */
class Logout extends ComponentAbstract {
    
    public function __construct() {
        
        CurrentUser::getInstance()->logout();
        header('Location: /');
    }
}