<?php

namespace NetBricks\News\Component\Backend;

use \NetCore\Component\Container;
use \NetBricks\Facade as _;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 02.12.11
 * @time: 12:35
 *
 * @property \NetBricks\Common\Link $crudListButton
 * @property \NetBricks\Common\Link $addButton
 * @property \NetBricks\Common\ContentSwitcher\ContentSwitcher $contentSwitcher
 */
class Layout extends Container
{

    public function __construct()
    {
        /**
         * @var \NetCore\Factory\Factory $f
         */
        $f = _::factory()->netBricks->common;
        $this->addChild($f->link(), 'crudListButton')
                ->addChild($f->link(), 'addButton')
                ->addChild($f->contentSwitcher->contentSwitcher(), 'contentSwitcher');

        $this->crudListButton
                ->addParam('action', 'list')
                ->addParam('content', 'news')
                ->setLabel('Lista');

        $this->addButton
                ->addParam('action', 'form')
                ->addParam('content', 'news')
                ->setLabel('Dodaj artykuł');

        $this->contentSwitcher->addCase('crud-list', '\NetBricks\News\Component\Backend\CrudList')
            ->addCase('form', '\NetBricks\News\Component\Backend\Form')
            ->setDefaultCaseName('list')
            ->switchTo(_::request()->getParam('action'));
    }

    public function render()
    {
        ?>
            <div class="articles_layout">
                <ul>
                    <li><?php echo $this->crudListButton; ?></li>
                    <li><?php echo $this->addButton; ?></li>
                </ul>
                <?php echo $this->contentSwitcher; ?>
            </div>
        <?php
    }

}
