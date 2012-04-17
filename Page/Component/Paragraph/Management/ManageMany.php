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

/**
 * @author: Sel <s@finalclass.net>
 * @date: 02.03.12
 * @time: 01:02
 */
class ManageMany extends Table
{

    public function __construct($options = array())
    {
        $data = _::services()->paragraph()->all();
        $this->setDataProvider($data)
                ->column('text', 'Text', function($that, ParagraphDocument $record) {
                    return $record->getText(_::languages()->getCurrent());
                })
                ->column('operations', 'Operations',
            function(ManageMany $that, ParagraphDocument $record)
            {
                return _::loader('/NetBricks/Common/Component/BasicCrud/ItemMenu')->create()
                        ->setRecordId($record->getId())
                        ->setRev($record->getRev())
                        ->setServiceName('paragraph');
            });
        parent::__construct($options);
    }

}