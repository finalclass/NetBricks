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

namespace NetBricks\News;

use \NetBricks\Facade as _;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 24.02.12
 * @time: 10:05
 */
class Resource extends \Zend_Application_Resource_ResourceAbstract
{

    public function init()
    {
        _::services()->news
                ->setNamespace('\NetBricks\News\Service\NewsService')
                ->setAllowed(array('news_admin', 'journalist'));
        _::services()->newsReader
                ->setNamespace('\NetBricks\News\Service\NewsReaderService')
                ->setAllowed('reader');

        if (_::env()->isDevelopment) {
            if (_::request()->get->installation->isOneOf(array('installation', 'news'))) {
                $this->install();
            }
        }
    }

    private function install()
    {
        $skeletonDoc = new \NetBricks\News\Model\NewsDocument();
        $skeletonRepo = new \NetBricks\News\Model\NewsRepository();
        _::couchdb()->initView(
            $skeletonDoc->toArray(),
            $skeletonRepo->designDocumentId,
            $skeletonRepo->viewName);

        _::couchdb()->initView(
            $skeletonDoc->toArray(),
            $skeletonRepo->designDocumentId,
            'by_publish_date',
            'doc.publish_date');

        return $this;
    }

}
