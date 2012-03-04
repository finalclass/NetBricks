<?php

namespace NetBricks\Common\Component\Form;

use \NetBricks\Common\Component\Form\FormElementAbstract;

/**
 * Author: Szymon Wygnański
 * Date: 12.09.11
 * Time: 04:01
 */
class Hidden extends FormElementAbstract
{

    protected $defaultAttributes = array('name', 'value');

    public function render()
    {
        echo '<input type="hidden"' . $this->renderTagAttributes($this->defaultAttributes) . '/>';
    }

}
