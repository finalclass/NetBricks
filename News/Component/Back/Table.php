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
namespace NetBricks\News\Component\Back;
use \NetBricks\Common\Component\Table as BaseTable;
use \NetBricks\Facade as _;
use \NetBricks\Common\Component\Extended\Renderer\Operations;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 29.04.12
 * @time: 12:50
 */
class Table extends BaseTable
{

    public function __construct($options = array())
    {
        parent::__construct($options);
        $this->column('title', 'nb_news_back_table_header_title')
                ->column('operations', 'nb_common_operations',
            Operations::factory()
                    ->setRemoveConfirmText('nb_news_back_remove_confirm_text')
                    ->setStateParam('nb_back_news')
                    ->setServiceName('news'));

    }

}
