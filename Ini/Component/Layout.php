<?php
/**
 * Layout
 *
 * Author: MMP
 */

namespace NetBricks\Ini\Component;

use \NetBricks\Ini\Component\ManagementList;
use \NetBricks\Common\Component\Container;
use \NetBricks\Common\Component\Event\ComponentEvent;
use \NetBricks\Common\Component\Title;
use \NetBricks\Common\Component\ContentSwitcher;
use \NetBricks\Facade as _;
use \NetBricks\Common\Component\Link;
use \NetBricks\Common\Component\RelativeLink;

/**
 *
 * @property \NetBricks\Common\Component\IconLink $addButton
 * @property \NetBricks\Common\Component\IconLink $listButton
 */
class Layout extends Container
{

    private $content;

    public function __construct($options = array())
    {

        $f = _::factory()->netBricks->common;

        $this->addButton = $f->iconLink()->addParam('action', 'list')->setLabel('List');
        $this->listButton = $f->iconLink()->addParam('action', 'add')->setLabel('Add');

        $this->content = new ManagementList();

        $this->addChild($this->listButton)
                ->addChild($this->addButton)
                ->addChild($this->content);

        parent::__construct($options);
    }


    public function setFilePath($value)
    {
        $this->options['file_path'] = $value;
        $this->content->setFilePath($value);
        return $this;
    }

    public function getFilePath()
    {
        return $this->options['file_path'];
    }

    public function setTitle($title)
    {
        $this->options['Title'] = $title;
        return $this;
    }

    public function getTitle()
    {
        return $this->options['Title'];
    }

    public function render()
    {
        ?>
    <h2><?php echo $this->options['Title'] ?></h2>
    <ul class="buttons">
        <li>
            <?php echo $this->addButton->setIconClass('ui-icon ui-icon-wrench'); ?>
        </li>
        <li>
            <?php echo $this->listButton->setIconClass('ui-icon ui-icon-plus'); ?>
        </li>
    </ul>
    <?php echo $this->content; ?>
    <?php
    }

}