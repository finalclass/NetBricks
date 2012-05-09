<?php

namespace NetBricks\User\Model;

use \NetBricks\User\Model\UserModel;
use \NetBricks\Facade as _;

/**
 * CurrentUser
 *
 * Author: MMP
 */
class CurrentUser extends UserModel {

    protected $id, $user, $currentUser;
    private static $instance = false;

    public function __construct() {
        $id = _::session()->currentUser->id->getString();

        $user = UserModel::find($id);
        if (!$user) {
            $user = $this->createGuest();
        }
        $this->setData($user->getData());
    }

    static private function createGuest() {
        $guest = new UserModel();
        return $guest->setEmail('')
            ->setRoles(array())
            ->setPassword('');
    }

    /**
     *
     * @return \NetBricks\User\Model\CurrentUser
     */
    public static function getInstance() {

        if (self::$instance === false) {
            self::$instance = new CurrentUser();
        }
        return self::$instance;
    }

    public function login($email, $password) {
        $u = UserModel::findByEmailAndPassword((string)$email, (string)$password);

        if ($u == null) {
            $u = $this->createGuest();
        }

        _::session()->currentUser->id = $u->getId();
        $this->setData($u->getData());
        return $this;
    }

    public function logout() {

        _::session()->currentUser->id = null;
        $this->setData(self::createGuest()->getData());
        return $this;
    }

    public function isLogged() {

        return (_::session()->currentUser->id->exists());
    }

}