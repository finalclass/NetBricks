<?php

namespace NetBricks\Common\Component\Form;

use \NetBricks\Common\Component\Tag;
use \NetBricks\Facade as _;

/**
 * Author: Szymon Wygnański
 * Date: 09.09.11
 * Time: 02:23
 */
abstract class FormElementAbstract extends Tag
{

    /**
     * @static
     * @param string $optionsOrTagName
     * @return \NetBricks\Common\Component\Form\FormElementAbstract
     */
    static public function factory($optionsOrTagName = 'input')
    {
        $class = get_called_class();
        return new $class($optionsOrTagName);
    }

    protected $defaultAttributes = array('id', 'class', 'style', 'name', 'value');

    /**
     * @param $value
     * @return \NetBricks\Common\Component\Form\FormElementAbstract
     */
    public function setValue($value)
    {
        $this->options['value'] = $value;
        return $this;
    }

    public function getValue()
    {
        return isset($this->options['value']) ? $this->options['value'] : $this->getPostValue();
    }

    /**
     * @param $value
     * @return \NetBricks\Common\Component\Form\FormElementAbstract
     */
    public function setName($value)
    {
        $this->options['name'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return isset($this->options['name']) ? $this->options['name'] : '';
    }

    public function getPostValue()
    {
        $name = $this->getName();
        $value = isset($this->options['value']) ? $this->options['value'] : '';
        return isset($_POST[$name]) ? $_POST[$name] : $value;
    }

    /**
     * @param array $value
     * @return \NetBricks\Common\Component\Form\FormElementAbstract
     */
    public function setErrors($value)
    {
        if(!is_array($value)) {
            $value = array($value);
        }

        foreach($value as $key=>$val) {
            $value[$key] = _::translate($val);
        }

        $this->options['errors'] = $value;
        if(!empty($value)) {
            $this->addClass($this->getErrorClassName());
        }
        return $this;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return (array)@$this->options['errors'];
    }

    public function hasErrors()
    {
        return !empty($this->options['errors']);
    }

    /**
     * @param string $errorClassName
     * @return FormElementAbstract
     */
    public function setErrorClassName($errorClassName)
    {
        $this->options['error_class_name'] = $errorClassName;
        if($this->hasErrors()) {
            $this->addClass($errorClassName);
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getErrorClassName()
    {
        return (string)@$this->options['error_class_name'];
    }

}
