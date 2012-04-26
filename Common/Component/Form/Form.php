<?php

namespace NetBricks\Common\Component\Form;

use \NetBricks\Common\Component\Tag;

/**
 * @author: Szymon Wygnański
 * @date: 09.09.11
 * @time: 02:10
 */
class Form extends Tag
{

    protected $defaultAttributes = array('action', 'method', 'enctype', 'id', 'class', 'style');

    /**
     * @param $value
     * @return Form
     */
    public function setEnctype($value)
    {
        $this->options['enctype'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getEnctype()
    {
        return isset($this->options['enctype']) ? $this->options['enctype'] : '';
    }

   /**
    * @param $value
    * @return Form
    */
    public function setMethod($value)
    {
        $this->options['method'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return isset($this->options['method']) ? $this->options['method'] : 'post';
    }


    /**
     * @param $value
     * @return Form
     */
    public function setAction($value)
    {
        $this->options['action'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return isset($this->options['action']) ? $this->options['action'] : ' ';
    }

    public function getTagName()
    {
        return 'form';
    }

    public function getValues()
    {
        $out = array();
        foreach($this->children as $child) {
            if($child instanceof FormElementAbstract) {
                $out[$child->getName()] = $child->getValue();
            }
        }
        return $out;
    }


    public function setValues($values)
    {
        foreach($this->children as $child) {
            if($child instanceof FormElementAbstract) {
                $val = empty($values[$child->getName()]) ? '' : $values[$child->getName()];
                if($val) {
                    $child->setValue($val);
                }
            }
        }
    }

}
