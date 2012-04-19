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

namespace NetBricks\Common\Component\BasicCrud;

use \NetBricks\Common\Component\UnorderedList;
use \NetBricks\Common\Component\IconLink;
use \NetBricks\Facade as _;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 02.03.12
 * @time: 09:20
 *
 * @property \NetBricks\Common\Component\Link $editButton
 * @property \NetBricks\Common\Component\Link $removeButton
 * @property string $stateParam
 */
class ItemMenu extends UnorderedList
{

    private $recordId = '';
    private $serviceName = '';
    private $removeConfirmText = 'Are you sure you want to remove?';


    /**
     * @static
     * @param array $options
     * @return \NetBricks\Common\Component\BasicCrud\ItemMenu
     */
        static public function factory($options = array())
        {
            $class = get_called_class();
            return new $class($options);
        }


    public function __construct($options = array())
    {
        $this->setClass('operations');

        $this->editButton = IconLink::factory()
                ->setIconClass('edit')
                ->setLabel('edit');

        $this->removeButton = IconLink::factory()
                ->setIconClass('trash')
                ->setLabel('delete');

        parent::__construct($options);
    }

    public function beforeRender()
    {
        if(!$this->editButton->getParam('id')) {
            $this->editButton->addParam('id', $this->getRecordId())
            ->addParam($this->stateParam(), 'edit');
        }

        $service = $this->getServiceName();
        if($service) {
            $rev = $this->getRev() ? '&rev=' . $this->getRev() : '';
            $redirect = '&redirect=' . urlencode(_::request()->getCurrentUrlFull());
            $this->removeButton->setHref('/-' . $this->getServiceName() . '-delete?'
                    . 'id=' . $this->getRecordId() . $rev . $redirect);
        }

        if(!$this->removeButton->getOnclick()) {
            $this->removeButton->setOnclick('return confirm("' . $this->getRemoveConfirmText() . '")');
        }
    }

    public function setServiceName($name)
    {
        $this->serviceName = (string)$name;
        return $this;
    }

    public function getServiceName()
    {
        return $this->serviceName;
    }

	public function stateParam($value = null)
	{
		if(!$value) {
			return empty($this->options['state_param'])
					? 'action' : $this->options['state_param'];
		}
		$this->options['state_param'] = $value;
		return $this;
	}

    public function setRecordId($id)
    {
        $this->recordId = (string)$id;
        return $this;
    }

    public function getRecordId()
    {
        return $this->recordId;
    }

    /**
     * @param string $value
     * @return \NetBricks\Common\Component\BasicCrud\ItemMenu
     */
    public function setRev($value)
    {
        $this->options['rev'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getRev()
    {
        return empty($this->options['rev']) ? '' : $this->options['rev'];
    }

    /**
     * default is: "Are you sure you want to remove?"
     *
     * @param $text
     * @return ItemMenu
     */
    public function setRemoveConfirmText($text)
    {
        $this->removeConfirmText = (string)$text;
        return $this;
    }

    public function getRemoveConfirmText()
    {
        return $this->removeConfirmText;
    }

}
