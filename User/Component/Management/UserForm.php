<?php

namespace NetBricks\User\Component\Management;

use \NetBricks\Common\Form\Form;
use \NetBricks\Common\Form\TextInput;
use \NetBricks\Common\Form\Password;
use \NetBricks\Common\Form\Submit;
use \NetBricks\Facade as _;
use \NetBricks\User\Model\UserModel;

/**
 * UserForm
 *
 * Author: MMP
 * @property \NetBricks\Common\Form\Hidden $id
 * @property \NetBricks\Common\Form\TextInput $email
 * @property \NetBricks\Common\Form\Password $password
 * @property \NetBricks\Common\Form\TextInput $roles
 * @property \NetBricks\Common\Form\Submit $submit
 */
class UserForm extends Form
{

    public $errors = '';

    public function __construct()
    {
        /**
         * @var \NetCore\Factory\Factory $f
         */
        $f = _::factory()->core->form;
        $this->id = $f->hidden()->setName('id');
        $this->email = $f->textInput()->setName('email');
        $this->password = $f->password()->setName('password');
        $this->roles = $f->textInput()->setName('roles');
        $this->submit = $f->submit()->setLabel('save');

        //If we are updating
        if (_::request()->user_id->exists()) {
            $userId = (string)_::request()->user_id;
            $user = UserModel::find($userId);
            if ($user !== null) {
                $this->setValues($user->toArray());
                $this->roles->setValue(join(', ', $user->getRoles()));
            }
        }

        //If we are inserting
        if (_::request()->isPost()) {
            if ($this->isValid()) {
                $obj = $this->assigningValuesFromPOST();
                $obj->save();
                header('Location: /admin/users/list');
            }
        }
    }

    public function isValid()
    {
        $this->setValues(_::request()->post->getValue());
        $errors = array();
        $emailValidator = new \Zend_Validate_EmailAddress();
        $passwordValidator = new \Zend_Validate_StringLength(array('min' => 6, 'max' => 20));
        $post = _::request()->post;

        if ((strlen($post->email->getString()) == 0)) {
            $errors[] = 'Email address cannot be empty';
        }

        if (!$emailValidator->isValid((string)$post->email->getString())) {
            $errors[] = 'Value is not an e-mail address';
        }

        if (strlen($post->password->getString()) == 0) {
            $errors[] = 'Password cannot be empty';
        }

        if (!$passwordValidator->isValid((string)$post->password->getString())) {
            $errors[] = 'Password has to be of 6-20 characters long';
        }

        //        if (UserModel::findByEmailAndPassword(((string) _::request()->email), ((string) _::request()->password)) == null) {
        //            $errors[] = 'Such user already exists!';
        //        }


        if (empty($errors)) {
            return true;
        }

        $this->errors = new \NetBricks\Common\UnorderedList();
        foreach ($errors as $error) {
            $this->errors->addChild(
                \NetBricks\Common\Tag::factory('span')->setContent($error)
            );
        }
        return false;
        //        return empty($errors);
        //
        //
        //
        //        if ((strlen(_::request()->email) > 0) && (strlen(_::request()->password) > 0)) {
        //            return true;
        //        }
        //
        //        $this->errors = new \NetBricks\Common\UnorderedList();
        //        $this->errors->addChild(
        //                \NetBricks\Common\Tag::factory('span')->setContent('Fill in user e-mail and password')
        //        );
        //
        //        $this->addChild($this->errors);
        //        return false;
    }

    public function render()
    {

        echo $this->errors;
        ?>
    <form method="post" action="">
        <table>
            <tr>
                <td>User e-mail:</td>
                <td><?php echo $this->email; ?></td>
            </tr>
            <tr>
                <td>User password:</td>
                <td><?php echo $this->password; ?></td>
            </tr>
            <tr>
                <td>User roles:</td>
                <td><?php echo $this->roles; ?></td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $this->submit; ?></td>
            </tr>
            <?php echo $this->id; ?>
        </table>
    </form>
    <?php
    }

    public function assigningValuesFromPOST()
    {

        $this->setValues(_::request()->post->getValue());
        $post = _::request()->post;
        $id = $post->id;

        if ($id->exists()) {
            $user = UserModel::find($id);
        } else {
            $user = new UserModel;
        }

        $user->setEmail($post->email->getString());
        $user->setPassword($post->password->getString());
        //we already have a validation, in case $roles is a string
        $user->setRoles($post->roles->getString());
        return $user;
    }
}