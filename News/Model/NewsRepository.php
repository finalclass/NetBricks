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
namespace NetBricks\News\Model;

use \NetBricks\Common\Document\Repository;
/**
 * @author: Sel <s@finalclass.net>
 * @date: 23.04.12
 * @time: 14:31
 */
class NewsRepository extends Repository
{
    public $designDocumentId = '_design/common';
    public $viewName = 'news';
    public $documentClassName = '\NetBricks\News\Model\NewsDocument';

    public function allByPublishDate($untilNow = false, $limit = null)
    {
        $startKey = null;
        if($untilNow) {
            $startKey = time() * 1000;
        }
        return $this->all('by_publish_date', $startKey, null, $limit, true);
    }

}
