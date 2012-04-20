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
namespace NetBricks\Common\Component\Extended\Renderer;
use \NetBricks\Common\Component\Extended\Renderer;
use \NetBricks\Common\Component\IconLink;
use \NetBricks\Facade as _;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 20.04.12
 * @time: 14:23
 *
 * @property \NetBricks\Common\Component\Link $editButton
 * @property \NetBricks\Common\Component\Link $removeButton
 */
class Operations extends Renderer
{

    /**
     * @param array $options
     * @return \NetBricks\Common\Component\Extended\Renderer\Operations
     */
    static public function factory($options = array())
    {
        return parent::factory($options);
    }

    public function construct()
    {
        $this->editButton = IconLink::factory()
                ->setIconClass('edit')
                ->setLabel('edit');

        $this->removeButton = IconLink::factory()
                ->setIconClass('trash')
                ->setLabel('delete');
    }

    /**
     * @param string $value
     * @return \NetBricks\Common\Component\Extended\Renderer\Operations
     */
    public function setStateParam($value)
    {
        $this->options['state_param'] = (string)$value;
        return $this;
    }

    /**
     * @return string
     */
    public function getStateParam()
    {
        return (string)@$this->options['state_param'];
    }

    /**
     * @param string $value
     * @return \NetBricks\Common\Component\Extended\Renderer\Operations
     */
    public function setServiceName($value)
    {
        $this->options['service_name'] = (string)$value;
        return $this;
    }

    /**
     * @return string
     */
    public function getServiceName()
    {
        return (string)@$this->options['service_name'];
    }

    /**
     * @param string $value
     * @return \NetBricks\Common\Component\Extended\Renderer\Operations
     */
    public function setRemoveConfirmText($value)
    {
        $this->options['remove_confirm_text'] = (string)$value;
        return $this;
    }

    /**
     * @return string
     */
    public function getRemoveConfirmText()
    {
        return (string)@$this->options['remove_confirm_text'];
    }

    protected function prepare()
    {
        $this->editButton->addParam('id', $this->getId())
                ->addParam($this->getStateParam(), 'edit');

        $service = $this->getServiceName();
        if ($service) {
            $rev = $this->getRev() ? '&rev=' . $this->getRev() : '';
            $redirect = '&redirect=' . urlencode(_::request()->getCurrentUrlFull());
            $this->removeButton->setHref('/-' . $this->getServiceName() . '-delete?'
                    . 'id=' . $this->getId() . $rev . $redirect);
        }

        if (!$this->removeButton->getOnclick()) {
            $this->removeButton->setOnclick("return confirm('" . $this->getRemoveConfirmText() . "')");
        }
    }

    public function setData($data)
    {
        parent::setData($data);
        $this->prepare();
    }

    public function render()
    {
        ?>
    <ul class="operations">
        <?php foreach($this->children as $child): ?>
        <li><?php echo $child; ?></li>
        <?php endforeach; ?>
    </ul>
    <?php

    }

    protected function getId()
    {
        return \NetCore\Renderer::renderObjectProperty($this->getData(), 'id');
    }

    protected function getRev()
    {
        return \NetCore\Renderer::renderObjectProperty($this->getData(), 'rev');
    }

}
