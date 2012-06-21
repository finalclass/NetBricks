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
namespace NetBricks\Page\Component;
use \NetBricks\Common\Component\Document\Html5;
use \NetBricks\Facade as _;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 21.06.12
 * @time: 14:46
 */
abstract class AbstractPageWithMeta extends Html5
{

    abstract protected function getPageId();

    public function __construct($options = array())
    {
        parent::__construct($options);
        $this->initMeta();
    }

    /**
     * @return \NetBricks\Page\Service\PageReader
     */
    private function getPageReaderService()
    {
        return _::services()->pageReader();
    }

    /**
     * @return \NetBricks\Page\Service\Page
     */
    private function getPageService()
    {
        return _::services()->page();
    }

    private function getPageDoc($id)
    {
        $page = $this->getPageReaderService()->get(array('id' => $id));
        if (!$page) {
            $page = $this->getPageService()->put(array('id' => $id));
        }
        return $page;
    }

    private function initMeta()
    {
        $pageId = $this->getPageId();
        if ($pageId === null) {
            return;
        }

        /** @var \NetBricks\Page\Document\Page $page */
        $page = $this->getPageDoc($pageId);

        /** @var $default \NetBricks\Page\Document\Page */
        $default = $this->getPageDoc('default');

        $robots = array();
        if ($page->getRobotsFollow()) {
            $robots[] = 'follow';
        }
        if ($page->getRobotsIndex()) {
            $robots[] = 'index';
        }

        _::cfg()->getHeader()->getTitle()
                ->setSeparator(' :: ')
                ->add($page->getMetaTitle());

        if($default->getMetaTitle()) {
            _::cfg()->getHeader()->getTitle()->add($default->getMetaTitle());
        }

        $keywords = $page->getMetaKeywords();
        if (empty($keywords)) {
            $keywords = $default->getMetaKeywords();
        }

        $description = $page->getMetaDescription();
        if (empty($description)) {
            $description = $default->getMetaDescription();
        }

        _::cfg()->getHeader()
                ->setKeywords(join(', ', $keywords))
                ->setDescription($description)
                ->setRobots(join(', ', $robots));
    }

}
