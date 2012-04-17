<?php

namespace NetBricks\News\Component\Backend;

use \NetBricks\Common\Component\Table;
use \NetBricks\Facade as _;
use \NetBricks\News\Model\NewsModel;

/**
 * Author: Sel <s@finalclass.net>
 * Date: 05.12.11
 * Time: 14:11
 */
class CrudList extends Table
{

    public function __construct()
    {
        parent::__construct();
        $this->setDataProvider(_::services()->news()->get(_::request()->get->getArray()))
                ->column('title', 'Tytuł')
                ->column('operations', 'Operacje', function(CrudList $table, NewsModel $record)
        {
            ?>
        <ul>
            <li>
                <?php echo $table->createLink()
                    ->setRouteName('edit_news')
                    ->addParam('action', 'form')
                    ->addParam('id', $record->getId())
                    ->setLabel('Edytuj'); ?>
            </li>
        </ul>
        <?php
        });
    }

    /**
     * @return \NetBricks\Common\Component\Link
     */
    public function createLink()
    {
        return _::factory()->netBricks->common->link()
                ->addParam('stage', _::request()->getParam('stage', 'admin'))
                ->addParam('content', _::request()->getParam('content', 'news'));
    }

}
