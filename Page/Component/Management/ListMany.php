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

namespace NetBricks\Page\Component\Management;

use \NetBricks\Common\Component\Table;
use \NetBricks\Page\Document\Page as PageDocument;
use \NetBricks\Common\Component\BasicCrud\ItemMenu;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 24.02.12
 * @time: 10:03
 */
class ListMany extends Table
{

    /**
     * @return \NetBricks\Page\Service\Page
     */
    private function getService()
    {
        return new \NetBricks\Page\Service\Page();
    }

    public function __construct($options = array())
    {
        $this->setDataProvider($this->getService()->all(array()))
                ->column('title', 'Title')
                ->column('operations', 'Operations', function($that, PageDocument $doc)
        {
            return ItemMenu::factory()
                    ->setRecordId($doc->getId())
                    ->setRev($doc->getRev())
                    ->setServiceName('page');
        });
        parent::__construct($options);
    }

}
