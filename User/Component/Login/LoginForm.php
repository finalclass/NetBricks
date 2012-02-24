<?php

namespace NetBricks\User\Component\Login;

use \NetCore\Factory\Factory;
use \NetCore\Component\Form\Form;
use \NetBricks\User\Model\UserModel;
use \NetBricks\User\Model\CurrentUser;
use \NetBricks\Facade as _;

/**
 * This class renders simple login form, if request is post then it tries to log in
 *
 * Author: Misiorus Maximus, modified by Sel
 *
 * @property \NetCore\Component\Form\TextInput $email
 * @property \NetCore\Component\Form\Password $password
 * @property \NetCore\Component\Form\Submit $logInButton
 * @property \NetCore\Component\UnorderedList $errors
 */
class LoginForm extends Form
{

    public function __construct($options = array())
    {
        parent::__construct($options);
        $this->email = _::loader('\NetCore\Component\Form\TextInput')->create()->setName('email');
        $this->password = _::loader('\NetCore\Component\Form\Password')->create()->setName('password');
        $this->logInButton = _::loader('\NetCore\Component\Form\Submit')->create()->setName('form')->setValue('login');
        $this->errors = _::loader('\NetCore\Component\UnorderedList')->create();

        if (_::request()->isPost() && _::request()->post->form->toString() == 'login') {
            $user = _::services()->login()->post();
            if(empty($user['errors']) ) {
                header('Location: ' . $this->getRedirectUrl());
            } else {
                $this->email->setValue($user['email']);
                $this->errors->setArrayAsContent($user['errors']);
            }
        }
    }

    public function render()
    {
        ?>
    <?php echo $this->errors; ?>
    <fieldset>
        <legend>Login</legend>
        <form action="" method="post">
            <dl>
                <dt>
                    <label for="email_input">Login</label>
                </dt>
                <dd>
                    <?php echo $this->email->setId('email_input'); ?>
                </dd>
                <dt>
                    <label for="password_input">Password</label>
                </dt>
                <dd>
                    <?php echo $this->password->setId('password_input'); ?>
                </dd>
            </dl>
            <?php echo $this->logInButton->setLabel('Log in'); ?>
        </form>
    </fieldset>
    <?php
    }

    /**
     * @param string $value
     * @return \NetBricks\User\Component\Login\LoginForm
     */
    public function setRedirectUrl($value)
    {
        $this->options['redirect_url'] = (string)$value;
        return $this;
    }

    /**
     * @return string
     */
    public function getRedirectUrl()
    {
        return empty($this->options['redirect_url']) ? '/admin' : $this->options['redirect_url'];
    }

}