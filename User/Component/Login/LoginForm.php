<?php

namespace NetBricks\User\Component\Login;

use \NetCore\Factory\Factory;
use \NetCore\Component\Form\Password;
use \NetCore\Component\Form\TextInput;
use \NetCore\Component\Form\Submit;
use \NetCore\Component\Form\Form;
use \NetBricks\User\Model\UserModel;
use \NetBricks\User\Model\CurrentUser;
use \NetBricks\Facade as _;

/**
 * This class renders simple login form
 *
 * Author: Misiorus Maximus
 */
class LoginForm extends Form
{

    public $email, $password, $logInButton;

    public function __construct()
    {

        $f = _::factory()->core->form;
        $this->email = $f->textInput()->setName('email')->setId('email_input');
        $this->password = $f->Password()->setName('password')->setId('password_input');
        $this->logInButton = $f->submit()->setLabel('Log in');

        $this->errors = _::factory()->core->unorderedList();

        $this->addChild($this->email)
                ->addChild($this->password)
                ->addChild($this->logInButton);

        if (_::request()->isPost()) {
            $user = _::services()->login()->post();
            if(empty($user['errors']) ) {
                header('Location: /admin');
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
        <form action="" method="post" value="login">
            <dl>
                <dt>
                    <label for="email_input">Login</label>
                </dt>
                <dd>
                    <?php echo $this->email; ?>
                </dd>
                <dt>
                    <label for="password_input">Password</label>
                </dt>
                <dd>
                    <?php echo $this->password; ?>
                </dd>
            </dl>
            <?php echo $this->logInButton; ?>
        </form>
    </fieldset>
    <?php
    }

}