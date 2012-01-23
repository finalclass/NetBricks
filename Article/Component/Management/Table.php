<?php

namespace NetBricks\Article\Component\Management;

use \NetCore\Component\Table as CoreTable;
use \NetBricks\Facade as _;
use \NetBricks\Article\Model\ArticleModel;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 08.12.11
 * @time: 10:38
 */
class Table extends CoreTable
{

    public function __construct()
    {
        parent::__construct();
        $this->setDataProvider(_::services()->article()->all())
            ->setClass('grid')
            ->column('title', 'Tytuł')
            ->column('category', 'Kategoria')
            ->column('list_order', 'Kolejność')
            ->column('operations', 'Operacje', array($this, 'renderOperations'));
    }

    public function renderOperations(Table $table, ArticleModel $article)
    {
        /**
         * @var \NetCore\Factory\Factory $linkFactory
         */
        $linkFactory = _::factory()->netBricks->common->iconLink;

        $editLink = $linkFactory()
                        ->addParam('action', 'form')
                        ->addParam('article_id', $article->getId())
                        ->setLabel('Edytuj');
        $removeLink = $linkFactory()
                        ->addParam('action', 'erase')
                        ->addParam('article_id', $article->getId())
                        ->setOnclick("return confirm('Czy jesteś pewien?');")
                        ->setLabel('Usuń');
        ?>
            <ul class="operations">
                <li>
                    <?php echo $editLink->setIconClass('ui-icon ui-icon-wrench'); ?>
                </li>
                <li>
                    <?php echo $removeLink->setIconClass('ui-icon ui-icon-trash'); ?>
                </li>
            </ul>
        <?php
    }
}
