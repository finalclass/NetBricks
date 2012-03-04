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

namespace NetBricks\Page\Component\Photo\Management;

use \NetBricks\Common\Component\Table;
use \NetBricks\Facade as _;
use \NetBricks\Page\Document\Photo as PhotoDocument;
use \NetBricks\Page\Service\Photo as PhotoService;
use \NetBricks\Common\Component\BasicCrud\ItemMenu;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 04.03.12
 * @time: 15:42
 */
class ManageMany extends Table
{

    private function getService()
    {
        static $service;
        if(!$service) {
            $service = new PhotoService();
        }
        return $service;
    }

    public function __construct($options = array())
    {
        $this->setDataProvider($this->getService()->all())
            ->column('src', 'Photo', function($that, PhotoDocument $record) {
                return '<img src="' . $record->getThumbSrc() . '" '
                         . 'alt="' . $record->getName(_::languages()->getCurrent()) .'" '
                          . 'width="' . $record->getThumbWidth() . 'px" '
                          . 'height="' . $record->getThumbHeight() . 'px"/>';
            })
            ->column('name', 'Name', function($that, PhotoDocument $record) {
                return $record->getName(_::languages()->getCurrent());
            })
            ->column('operations', 'Operations', function($that, PhotoDocument $record) {
                return ItemMenu::factory()
                        ->setRecordId($record->getId())
                        ->setRev($record->getRev())
                        ->setServiceName('photo');
            });
        parent::__construct($options);
    }

}
