<?php

namespace NetBricks\Common\Component\Form;

use \NetBricks\Common\Component\Form\FormElementAbstract;
use \NetBricks\Facade as _;

/**
 * Author: Szymon Wygnański
 * Date: 12.09.11
 * Time: 04:21
 */
class Submit extends FormElementAbstract
{

    /**
     * @static
     * @param string $optionsOrTagName
     * @return \NetBricks\Common\Component\Form\Submit
     */
    static public function factory($optionsOrTagName = 'input')
    {
        $class = get_called_class();
        return new $class($optionsOrTagName);
    }

    private $label;

    protected $defaultAttributes = array('type', 'name', 'id', 'class', 'style');

    public function render()
    {
        ?>
    <input <?php echo $this->renderTagAttributes($this->defaultAttributes); ?>
            value="<?php echo $this->getLabel(); ?>"/>
    <input type="hidden"
           name="<?php echo $this->getName(); ?>"
           value="<?php echo $this->getValue(); ?>"/>
    <?php
    }

    public function getTagName()
    {
        return 'input';
    }

    public function getType()
    {
        return 'submit';
    }

    /**
     * @param $value
     * @return Submit
     */
    public function setLabel($value)
    {
        $this->options['label'] = _::translate($value);
        return $this;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return isset($this->options['label']) ? $this->options['label'] : '';
    }

}
