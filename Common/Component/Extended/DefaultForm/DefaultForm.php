<?php
/**

Copyright (C) Szymon Wygnanski (s@finalclass.net)

Permission is hereby granted, free of charge, to any person obtaining a copy of
this software and associated documentation files (the "Software"), to deal in
the Software without restriction, including without limitation the rights to
use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies
of the Software, and to permit persons to whom the Software is furnished to do
so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
 */
namespace NetBricks\Common\Component\Extended;
use \NetBricks\Common\Component\Extended\AbstractForm;
use \NetBricks\Common\Component\Form\Submit;
use \NetBricks\Common\Component\Link;
use \NetBricks\Facade as _;
use \NetBricks\Common\Component\Form\FormElementAbstract;


/**
 * @author: Sel <s@finalclass.net>
 * @date: 25.04.12
 * @time: 01:05
 *
 * @property \NetBricks\Common\Component\Form\Submit $submit
 * @property \NetBricks\Common\Component\Link $cancel
 */
abstract class DefaultForm extends AbstractForm
{

    protected $elements = array();

    public function __construct($options = array())
    {
        $this->setEnctype('multipart/form-data');
        _::cfg()->getHeader()->getStyleSheets()
                ->addNetBricks();

        $this->submit = Submit::factory()
                ->setLabel('Submit')
                ->setName('form');

        $this->cancel = Link::factory()
                ->setLabel('Cancel');

        $this->addClass('nb-default-form');

        parent::__construct($options);
    }

    public function getValues()
    {
        $out = array();
        foreach ($this->children as $child) {
            if ($child instanceof DefaultForm\ElementContainer) {
                $element = $child->element;
            } else if ($child instanceof FormElementAbstract) {
                $element = $child;
            } else {
                continue;
            }
            $out[$element->getName()] = $element->getValue();
        }
        return $out;
    }


    public function setValues($values)
    {
        foreach ($this->children as $child) {
            if ($child instanceof DefaultForm\ElementContainer) {
                $element = $child->element;
            } else if ($child instanceof FormElementAbstract) {
                $element = $child;
            } else {
                continue;
            }
            $val = empty($values[$element->getName()])
                    ? '' : $values[$element->getName()];
            if ($val) {
                $element->setValue($val);
            }
        }
        return $this;
    }


    /**
     * @param string $value
     * @return \NetBricks\Common\Component\Extended\DefaultForm
     */
    public function setSubLegend($value)
    {
        $this->options['sub_legend'] = (string)$value;
        return $this;
    }

    /**
     * @return string
     */
    public function getSubLegend()
    {
        return (string)@$this->options['sub_legend'];
    }

    /**
     * @param string $value
     * @return \NetBricks\Common\Component\Extended\DefaultForm
     */
    public function setLegend($value)
    {
        $this->options['legend'] = (string)$value;
        return $this;
    }

    /**
     * @return string
     */
    public function getLegend()
    {
        return (string)@$this->options['legend'];
    }

    public function addElement(DefaultForm\ElementContainer $element)
    {
        $this->addChild($element);
        $this->elements[] = $element;
        return $this;
    }

    public function render()
    {
        $subLegend = $this->getSubLegend();
        ?>
    <?php echo $this->formStart(); ?>
    <fieldset class="nb-vbox">
        <legend>
            <?php echo $this->getLegend(); ?>
            <?php if ($subLegend): ?>
            <sub><?php echo $subLegend; ?></sub>
            <?php endif; ?>
        </legend>

        <?php echo join(PHP_EOL . PHP_EOL, $this->elements); ?>

        <div class="nb-hbox">
            <label for=""></label>

            <div class="nb-form-element">
                <?php echo $this->submit; ?>
                <?php echo $this->cancel; ?>
            </div>
        </div>

    </fieldset>
    <?php echo $this->formEnd(); ?>
    <?php

    }

}
