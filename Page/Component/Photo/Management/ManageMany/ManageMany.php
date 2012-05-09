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
use \NetBricks\Common\Component\Tag;
use \NetBricks\Page\Component\Photo\Management\ManageMany\PhotoBox;
use \NetBricks\Facade as _;
/**
 * @author: Sel <s@finalclass.net>
 * @date: 08.05.12
 * @time: 15:27
 */
class ManageMany extends Tag
{

    public function __construct($options = array())
    {
        parent::__construct($options);

        $this->addClass('nb_page_photo_manage_many');
        $height = _::cfg()->getPage()->getPhoto()->getThumbHeight();

        foreach($this->getService()->all() as $photo) {
            /** @var $photo \NetBricks\Page\Document\Photo */
            $box = new PhotoBox();
            $box->setDocument($photo)
                ->addClass('photo_box');
            $id = $photo->getId();
            //Add child:
            $this->$id = $box;
        }
    }

    /**
     * @return \NetBricks\Page\Service\PhotoReader
     */
    private function getService()
    {
        return _::services()->photoReader();
    }

}
