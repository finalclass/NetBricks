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
 * @property \NetBricks\Common\Component\IconLink $editButton
 * @property \NetBricks\Common\Component\IconLink $removeButton
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
        parent::__construct($options);

        _::cfg()->getHeader()->getStyleSheets()->addJQueryUi()->addNetBricks();

        $this->addClass('nb-operations');

        $this->editButton = IconLink::factory()
                ->setIconClass('ui-icon ui-icon-pencil')
                ->setLabel('edit')
                ->setClass('ui-state-default ui-corner-all nb-button');

        $this->removeButton = IconLink::factory()
                ->setIconClass('ui-icon ui-icon-trash')
                ->setLabel('delete')
                ->addParam('redirect', urlencode(_::request()->getCurrentUrlFull()))
                ->addClass('ui-state-default ui-corner-all nb-button');

    }

    public function setServiceName($name)
    {
        $this->serviceName = (string)$name;
        $this->removeButton->addParam('service', $name . '-delete');
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
        $this->editButton->addParam($this->stateParam(), 'edit');
		return $this;
	}

    public function setRecordId($id)
    {
        $this->recordId = (string)$id;
        $this->editButton->addParam('id', $id);
        $this->removeButton->addParam('id', $id);
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
        $this->removeButton->addParam('rev', $value);
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
        $text = _::translate((string)$text);
        $this->removeConfirmText = $text;
        $this->removeButton->setOnclick("return confirm('" . $text . "')");
        return $this;
    }

    public function getRemoveConfirmText()
    {
        return $this->removeConfirmText;
    }

}
