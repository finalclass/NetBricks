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

/**
 * @author: Sel <s@finalclass.net>
 * @date: 04.03.12
 * @time: 15:26
 */
class Photo
{

    /**
     * @return \NetBricks\Page\Document\Photo\Repository
     */
    private function getRepo()
    {
        return new \NetBricks\Page\Document\Photo\Repository();
    }

    public function get()
    {
        return $this->getRepo()->find(_::request()->get->id->getString());
    }

    public function all()
    {
        return $this->getRepo()->all();
    }

    public function post()
    {
        $post = _::request()->post->getArray();
        $repo = $this->getRepo();
        unset($post['form']);
        if(!empty($post['_id'])) {
            $doc = $repo->find($post['id']);
            $doc->fromArray($post);
        } else {
            $doc = new \NetBricks\Page\Document\Photo();
            unset($post['_rev']);
            unset($post['_id']);
            $doc->fromArray($post);
        }
        $doc->addAttachment(basename($_FILES['photo']['name']), $_FILES['photo']['tmp_name']);
        return $repo->save($doc);
    }

    public function delete()
    {
        return _::couchdb()->delete(_::request()->id, _::request()->rev);
    }

}
