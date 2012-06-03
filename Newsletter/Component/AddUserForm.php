<?php
/**
 * Created by JetBrains PhpStorm.
 * User: sel
 * Date: 03.06.12
 * Time: 12:42
 *
 *
 *
 */

namespace NetBricks\Newsletter\Component;

use \NetBricks\Facade as _;
use \NetBricks\Common\Component\Extended\AbstractForm;
use \NetBricks\Common\Component\Form\TextInput;
use \NetBricks\Common\Component\Form\Submit;

/**
 * @property \NetBricks\Common\Component\Form\TextInput $email
 * @property \NetBricks\Common\Component\Form\Submit $submit
 */
class AddUserForm extends AbstractForm
{

    public function __construct($params = array())
    {
        $this->email = TextInput::factory()->setName('email');
        $this->submit = Submit::factory()->setName('form')->setValue('newsletter_subscription');
        parent::__construct($params);
    }

    protected function getService()
    {
        return _::services()->nb_newsletter_subscription();
    }

    public function redirect()
    {
        //redirect to self
        _::url()->addCurrentParams()->redirect();
    }

}
