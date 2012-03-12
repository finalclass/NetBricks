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

namespace NetBricks\Page\Service;
use \NetBricks\Facade as _;
use \NetBricks\Page\Document\Page as PageModel;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 24.02.12
 * @time: 10:04
 */
class Page
{

    /**
     * @return \NetBricks\Page\Document\Page\Repository
     */
    private function getRepo()
    {
        return new \NetBricks\Page\Document\Page\Repository();
    }

    /**
     * @return \NetBricks\Page\Document\Page[]
     */
    public function all()
    {
        return $this->getRepo()->all();
    }

    /**
     * @return \NetBricks\Page\Document\Page
     */
    public function get()
    {
        return $this->getRepo()->find(_::request()->id->getString());
    }

    /**
     * @return \NetBricks\Page\Document\Page
     */
    public function post()
    {

    }

}
