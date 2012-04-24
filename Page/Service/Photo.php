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

    public function get($params = array())
    {
        if(!isset($params['id'])) {
            return $this->all();
        }
        return $this->getRepo()->find($params['id']);
    }

    public function all($params = array())
    {
        return $this->getRepo()->all();
    }

    public function post($params)
    {

        $repo = $this->getRepo();
        unset($params['form']);
        if (!empty($params['_id'])) {
            $doc = $repo->find($params['_id']);
            $doc->fromArray($params);
        } else {
            $doc = new \NetBricks\Page\Document\Photo();
            unset($params['_rev']);
            unset($params['_id']);
            $doc->fromArray($params);
        }

        if (@$_FILES['photo']['tmp_name']) {
            $bigPath = $this->createBigImage($_FILES['photo']['tmp_name']);
            $thumbPath = $this->createThumbImage($_FILES['photo']['tmp_name']);

            $doc->addAttachment('original.jpg', $_FILES['photo']['tmp_name']);
            $doc->addAttachment('big.jpg', $bigPath);
            $doc->addAttachment('thumb.jpg', $thumbPath);
        }
        return $repo->save($doc);
    }

    private function createBigImage($sourceFilePath)
    {
        $cfg = _::cfg()->getPage()->getPhoto();
        $img = new \NetCore\Image();

        $img->getConfig()
                ->setSource($sourceFilePath)
                ->setWidth($cfg->getBigWidth())
                ->setRatioHeight(true)
                ->setRatioNoZoomIn(true)
                ->setAutoConvertByExtension(false)
                ->setConvertTo('jpg');

        $destinationPath = tempnam(_::cfg()->getTempDir(), 'thumb');
        $img->save($destinationPath);
        return $destinationPath;
    }

    private function createThumbImage($sourceFilePath)
    {
        $cfg = _::cfg()->getPage()->getPhoto();
        $img = new \NetCore\Image();
        $img->getConfig()
                ->setSource($sourceFilePath)
                ->setWidth($cfg->getThumbWidth())
                ->setRatioHeight(true)
                ->setRatioNoZoomIn(true)
                ->setAutoConvertByExtension(false)
                ->setConvertTo('jpg');

        $destinationPath = tempnam(_::cfg()->getTempDir(), 'thumb');
        $img->save($destinationPath);
        return $destinationPath;
    }

    public function delete($params)
    {
        return _::couchdb()->delete($params['id'], $params['rev']);
    }

}
