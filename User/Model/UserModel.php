<?php

namespace NetBricks\User\Model;

use \NetCore\FileSystem\Model;
use NetBricks\Facade as _;

/**
 * UserModel
 *
 * Author: Misiorus Maximus
 */
class UserModel extends Model {

    protected $user;

    public function __construct() {

        parent::__construct();
    }

    static public function getDir()
    {
        return _::cfg()->getUser()->getSavePath();
    }

    protected function getFieldToGenerateId() {

        return 'email';
    }

    /**
     *
     * Finds a User by $email and $password.
     * If such User exists, the function will return an object of UserModel.
     * If such User does not exist, the function will return null.
     * 
     * @param string $email
     * @param string $password
     * @return UserModel|null User found by specified $email and $password
     */
    static public function findByEmailAndPassword($email, $password) {
        $usersArray = static::findAll();
        foreach ($usersArray as $user) {
            /**
             * @var UserModel $user
             */
            $encryptedPasswordMatch = strcmp($user->getPassword(), md5($password)) == 0;
            $passwordMatch = strcmp($user->getPassword(), $password) == 0;
            $emailMatch = strcmp($user->getEmail(), $email) == 0;
            if ( ($encryptedPasswordMatch || $passwordMatch) && $emailMatch)
                return $user;
        }
        return null;
    }

    /**
     *
     * Sets an email address for User.
     *
     * @TODO implement test, if email address is not valid.
     * 
     * @param string $email
     * @return UserModel 
     * 
     */
    public function setEmail($email) {

        $this->data['email'] = (string)$email;
        return $this;
    }

    /**
     *
     * @return string an email address of User.
     */
    public function getEmail() {

        return empty($this->data['email']) ? '' : $this->data['email'];
    }

    /**
     *
     * Sets and encrypt (md5) password for User.
     * 
     * @param string $password
     * @return UserModel 
     * 
     */
    public function setPassword($password) {

        $this->data['password'] = md5($password);
        return $this;
    }

    /**
     * 
     * @return string encrypted user password
     */
    public function getPassword() {

        return empty($this->data['password']) ? 'default' : $this->data['password'];
    }

    /**
     *
     * Sets an array of roles to User.
     * If User sets string instead of array, function shoul convert it to array.
     *
     * @param array|string $roles
     * @return UserModel
     */
    public function setRoles($roles=array()) {

        if (is_string($roles)) {
            $roles = strtolower(str_replace(array('?', ' ', ',', '-', '_', ':', '/', '\\',), ' ', $roles));
            $roles = array_filter(explode(' ', $roles));
        }

        $this->data['roles'] = $roles;
        return $this;
    }

    /**
     *
     * @return array an array of roles assigned to User. If roles are not assigned to User, the function will return an empty array.
     */
    public function getRoles() {

        return isset($this->data['roles']) ? $this->data['roles'] : array();
    }

    /**
     *
     * Adds role $roleName to User.
     * 
     * @param string $roleName
     * @return UserModel 
     * 
     */
    public function addRole($roleName) {

        $r = $this->getRoles();
        if (empty($r))
            $this->data['roles'] = array($roleName);
        else
            $this->data['roles'][] = $roleName;
        return $this;
    }

    /**
     *
     * Removes current role from User.
     * If no role is assigned to User, function simply returns.
     * 
     * @param string $roleName
     * @return UserModel
     * 
     */
    public function removeRole($roleName) {

        $r = $this->hasRole($roleName);
        if ($r == false)
            return $this;
        else
            foreach ($this->data['roles'] as $roleName)
                $this->data['roles'] = str_ireplace($roleName, '', $this->data['roles']);
        return $this;
    }

    /**
     * Tests whether User has its role defined by $roleName.
     * If so, function returns true, else it returns false.
     * 
     * @param string $roleName
     * @return bool true if user has role
     * 
     */
    public function hasRole($roleName) {

        $array = array();
        $array = $this->getRoles();
        foreach ($array as $value) {
            if ($value === $roleName)
                return true;
        }
        return false;
    }
}