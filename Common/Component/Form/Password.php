<?php

namespace NetBricks\Common\Component\Form;

use \NetBricks\Common\Component\Form\FormElementAbstract;

/**
 * Author: Misiorus Maximus
 */
class Password extends FormElementAbstract
{

    public function render()
    {
        echo '<input type="password" '
             . $this->renderTagAttributes(array('name', 'class', 'id', 'value', 'style'))
             . '/>';
    }

    

}