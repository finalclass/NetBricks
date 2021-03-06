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

namespace NetBricks\Page\Component\Paragraph\Management;

use \NetBricks\Common\Component\Table;
use \NetBricks\Facade as _;
use \NetBricks\Common\Component\Link;
use \NetBricks\Page\Document\Paragraph as ParagraphDocument;
use \NetBricks\Common\Component\BasicCrud\ItemMenu;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 02.03.12
 * @time: 01:02
 */
class ManageMany extends Table
{

    public function __construct($options = array())
    {
        _::cfg()->getHeader()->getScripts()->addJQuery()->addNetBricks();
        $this->addClass('nb_page_paragraph_manage_many');
        $data = _::services()->paragraph()->all();

        $filter = new \Zend_Filter();
        $filter->addFilter(new \Zend_Filter_StripTags())
                ->addFilter(new \NetCore\Filter\ShrinkText());

        $this->setDataProvider($data)
                ->column('id', 'Id')
                ->column('text', 'Text', function($that, ParagraphDocument $record) use($filter)
        {
            return $filter->filter($record->getText());
        })
                ->column('operations', 'Operations',
            function(ManageMany $that, ParagraphDocument $record)
            {
                $menu = new ItemMenu();
                $menu->setRecordId($record->getId())
                        ->setRev($record->getRev())
                        ->stateParam('action')
                        ->setServiceName('paragraph');

                $menu->editButton->addParam('action', 'edit');

                $menu->setRemoveConfirmText('nb_page_paragraph_remove_confirm');

                $menu->removeButton->addClass('remove');

                if(!$record->getIsDeletable()) {
                    $menu->removeButton->setNoRender(true);
                }
                return $menu;
            });
        parent::__construct($options);
    }

}
