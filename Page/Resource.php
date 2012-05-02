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

namespace NetBricks\Page;

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
        _::services()->page->setNamespace('\NetBricks\Page\Service\Page');
        _::services()->pageWidgetType->setNamespace('\NetBricks\Page\Service\PageWidgetType');
        _::services()->paragraphReader->setNamespace('\NetBricks\Page\Service\ParagraphReader');
        _::services()->paragraph->setNamespace('\NetBricks\Page\Service\Paragraph');
        _::services()->photo->setNamespace('\NetBricks\Page\Service\Photo');

        if (_::request()->get->installation == 'installation') {
            $this->installPage();
            $this->installParagraph();
            $this->installPhoto();
        }
    }

    private function installPage()
    {
        $pageDoc = new \NetBricks\Page\Document\Page();
        $pageRepo = new \Netbricks\Page\Document\Page\Repository();
        _::couchdb()->initView($pageDoc->toArray(), $pageRepo->designDocumentId, $pageRepo->viewName);
        return $this;
    }

    private function installParagraph()
    {
        $paragraphDoc = new \NetBricks\Page\Document\Paragraph();
        $paragraphRepo = new \Netbricks\Page\Document\Paragraph\Repository();
        _::couchdb()->initView($paragraphDoc->toArray(), $paragraphRepo->designDocumentId, $paragraphRepo->viewName);
        return $this;
    }

    private function installPhoto()
    {
        $photoDoc = new \NetBricks\Page\Document\Photo();
        $photoRepo = new \Netbricks\Page\Document\Photo\Repository();
        _::couchdb()->initView($photoDoc->toArray(), $photoRepo->designDocumentId, $photoRepo->viewName);
        return $this;
    }

}
