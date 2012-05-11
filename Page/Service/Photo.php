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
class Photo extends PhotoReader
{

    public function delete($params)
    {
        return _::couchdb()->delete($params['id'], $params['rev']);
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

        try {
            if (@$_FILES['photo']['tmp_name']) {
                $doc->addAttachment('original.jpg', $_FILES['photo']['tmp_name']);

                $bigPath = $this->createBigImage($_FILES['photo']['tmp_name']);
                list($x, $y) = $this->getSize($bigPath);
                $doc->setBigWidth($x)
                        ->setBigHeight($y)
                        ->addAttachment('big.jpg', $bigPath);

                $thumbPath = $this->createThumbImage($_FILES['photo']['tmp_name']);
                list($x, $y) = $this->getSize($thumbPath);
                $doc->setThumbWidth($x)
                        ->setThumbHeight($y)
                        ->addAttachment('thumb.jpg', $thumbPath);

                $iconPath = $this->createIconImage($_FILES['photo']['tmp_name']);
                list($x, $y) = $this->getSize($iconPath);
                $doc->setIconWidth($x)
                        ->setIconHeight($y)
                        ->addAttachment('icon.jpg', $iconPath);

                $tinyPath = $this->createTinyImage($_FILES['photo']['tmp_name']);
                list($x, $y) = $this->getSize($tinyPath);
                $doc->setTinyWidth($x)
                        ->setTinyHeight($y)
                        ->addAttachment('tiny.jpg', $tinyPath);

                $middlePath = $this->createMiddleImage($_FILES['photo']['tmp_name']);
                list($x, $y) = $this->getSize($middlePath);
                $doc->setMiddleWidth($x)
                        ->setMiddleHeight($y)
                        ->addAttachment('middle.jpg', $middlePath);

            }
            $repo->save($doc);
        } catch(\NetCore\Image\Exception\WrongSourceType $e) {
            $doc->setErrors(array('photo' => array(_::translate('nb_page_photo_error_wrong_source_type'))));
        }

        return $doc;
    }

    private function getSize($path)
    {
        list($width, $height, $type, $attr) = getimagesize($path);
        return array($width, $height);
    }

    private function createBigImage($sourceFilePath)
    {
        $cfg = _::cfg()->getPage()->getPhoto();
        $img = new \NetCore\Image();

        $img->getConfig()
                ->setSource($sourceFilePath)
                ->setWidth($cfg->getBigWidth())
                ->setHeight($cfg->getBigHeight())
                ->setRatioNoZoomIn(true)
                ->setAutoConvertByExtension(false)
                ->setConvertTo('jpg');

        if($cfg->getBigRatioWidth()) {
            $img->getConfig()->setRatioWidth(true);
        }
        if($cfg->getBigRatioHeight()) {
            $img->getConfig()->setRatioHeight(true);
        }

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
                ->setHeight($cfg->getThumbHeight())
                ->setRatioNoZoomIn(true)
                ->setAutoConvertByExtension(false)
                ->setConvertTo('jpg');

        if($cfg->getThumbRatioWidth()) {
            $img->getConfig()->setRatioWidth(true);
        }
        if($cfg->getThumbRatioHeight()) {
            $img->getConfig()->setRatioHeight(true);
        }

        $destinationPath = tempnam(_::cfg()->getTempDir(), 'thumb');
        $img->save($destinationPath);
        return $destinationPath;
    }

    private function createIconImage($sourceFilePath)
    {
        $cfg = _::cfg()->getPage()->getPhoto();
        $img = new \NetCore\Image();
        $img->getConfig()
                ->setSource($sourceFilePath)
                ->setWidth($cfg->getIconWidth())
                ->setHeight($cfg->getIconHeight())
                ->setRatioNoZoomIn(true)
                ->setAutoConvertByExtension(false)
                ->setConvertTo('jpg');

        if($cfg->getIconRatioWidth()) {
            $img->getConfig()->setRatioWidth(true);
        }
        if($cfg->getIconRatioHeight()) {
            $img->getConfig()->setRatioHeight(true);
        }

        $destinationPath = tempnam(_::cfg()->getTempDir(), 'icon');
        $img->save($destinationPath);
        return $destinationPath;
    }

    private function createTinyImage($sourceFilePath)
    {
        $cfg = _::cfg()->getPage()->getPhoto();
        $img = new \NetCore\Image();
        $img->getConfig()
                ->setSource($sourceFilePath)
                ->setWidth($cfg->getTinyWidth())
                ->setHeight($cfg->getTinyHeight())
                ->setRatioNoZoomIn(true)
                ->setAutoConvertByExtension(false)
                ->setConvertTo('jpg');

        if($cfg->getTinyRatioWidth()) {
            $img->getConfig()->setRatioWidth(true);
        }
        if($cfg->getTinyRatioHeight()) {
            $img->getConfig()->setRatioHeight(true);
        }

        $destinationPath = tempnam(_::cfg()->getTempDir(), 'tiny');
        $img->save($destinationPath);
        return $destinationPath;
    }

    private function createMiddleImage($sourceFilePath)
    {
        $cfg = _::cfg()->getPage()->getPhoto();
        $img = new \NetCore\Image();
        $img->getConfig()
                ->setSource($sourceFilePath)
                ->setWidth($cfg->getMiddleWidth())
                ->setHeight($cfg->getMiddleHeight())
                ->setRatioNoZoomIn(true)
                ->setAutoConvertByExtension(false)
                ->setConvertTo('jpg');

        if($cfg->getMiddleRatioWidth()) {
            $img->getConfig()->setRatioWidth(true);
        }
        if($cfg->getMiddleRatioHeight()) {
            $img->getConfig()->setRatioHeight(true);
        }

        $destinationPath = tempnam(_::cfg()->getTempDir(), 'middle');
        $img->save($destinationPath);
        return $destinationPath;
    }

}
