<?php

namespace NetBricks\Common\Component\Form;

use \NetBricks\Common\Component\Form\FormElementAbstract;
use \NetBricks\Facade as _;

/**
 * Author: Szymon Wygnański
 * Date: 09.09.11
 * Time: 02:21
 */
class TextInput extends FormElementAbstract
{

    /**
     * @param string $value
     * @return \NetBricks\Common\Component\Form\TextInput
     */
    public function setPlaceholder($value)
    {
        $this->options['placeholder'] = _::translate($value);
        return $this;
    }

    /**
     * @return string
     */
    public function getPlaceholder()
    {
        return empty($this->options['placeholder']) ? '' : $this->options['placeholder'];
    }

    public function render()
    {
        echo '<input type="text" '
             . $this->renderTagAttributes(array('size', 'name', 'class', 'id', 'value', 'style', 'placeholder'))
             . '/>';
    }

    public function setValue($value)
    {
        if(is_array($value)) {
            $value = join(', ', $value);
        }
        return parent::setValue($value);
    }

    /**
     * @param $value
     * @return TextInput
     */
    public function setSize($value)
    {
        $this->options['size'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getSize()
    {
        return (string)@$this->options['size'];
    }


}
