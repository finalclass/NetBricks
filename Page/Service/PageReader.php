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
class PageReader
{

    /**
     * @return \NetBricks\Page\Document\Page\Repository
     */
    public function getRepo()
    {
        return new \NetBricks\Page\Document\Page\Repository();
    }

    /**
     * @param $params
     * @return \NetBricks\Page\Document\Page[]
     */
    public function all($params = array())
    {
        return $this->getRepo()->all();
    }

    /**
     * @param $params
     * @return \NetBricks\Page\Document\Page
     */
    public function get($params = null)
    {
        if(!$params || !isset($params['id'])) {
            return $this->all();
        }
        return $this->getRepo()->find($params['id']);
    }

}
