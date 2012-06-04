<?php
/**
 * Created by JetBrains PhpStorm.
 * User: sel
 * Date: 04.06.12
 * Time: 09:49
 * To change this template use File | Settings | File Templates.
 */

namespace NetBricks\Newsletter\Component\Management;

use \NetBricks\Common\Component\Table as BaseTable;
use \NetBricks\Facade;
use \NetBricks\Common\Component\Extended\Renderer\Operations;
use \NetBricks\Common\Component\BasicCrud\ItemMenu;
use \NetBricks\Newsletter\Document\NewsletterUser;

class Table extends BaseTable
{

    public function __construct($params = array())
    {
        $this->addClass('nb_newsletter_management_table');

        $this->column('email', 'E-mail')
                ->column('operations', 'Operations', function(Table $that, NewsletterUser $record)
        {
            $menu = new ItemMenu();
            $menu->setRecordId($record->getId())
                    ->setRev($record->getRev())
                    ->stateParam('action')
                    ->setServiceName('paragraph');

            $menu->editButton->addParam('action', 'edit');
            $menu->editButton->setNoRender(true);
            $menu->setRemoveConfirmText('nb_newsletter_user_remove_confirm');
            $menu->removeButton->addClass('remove');

            return $menu;
        })
                ->setDataProvider($this->getService()->get());

        parent::__construct($params);
    }

    /**
     * @return \NetBricks\Newsletter\Service\NewsletterUser
     */
    public function getService()
    {
        return new \NetBricks\Newsletter\Service\NewsletterUser();
    }

}
