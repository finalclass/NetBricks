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
namespace NetBricks\Page\Component\Photo;

use \NetBricks\Common\Component\Container;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 19.03.12
 * @time: 12:28
 */
class PhotoWidget extends Container
{

    public function init()
    {
        $doc = $this->getPhotoDocument();
        if($doc) {
            $photo = new \NetBricks\Page\Component\Photo\Thumb();
            $photo->setPhotoDocument($doc);
            $this->addChild($photo);
        } else {
            $selector = new Selector();
            $this->addChild($selector);
        }
    }

    public function render()
    {
        ?>
            <div class="nb_page_photo_widget">
                <?php echo join(PHP_EOL, $this->children); ?>
            </div>
        <?php
    }

    /**
     * @param \NetBricks\Page\Document\Photo $doc
     * @return \NetBricks\Page\Component\Photo
     */
    public function setPhotoDocument(\NetBricks\Page\Document\Photo $doc)
    {
        $this->options['photo_document'] = $doc;
        $this->options['photo_document_id'] = $doc->getId();
        $this->image->setAlt($doc->getName())
                ->setWidth($doc->getBigWidth())
                ->setHeight($doc->getBigHeight())
                ->setSrc($doc->getBigSrc());
        return $this;
    }

    /**
     * @return PhotoDocument
     */
    public function getPhotoDocument()
    {
        return @$this->options['photo_document'];
    }

    /**
     * @param string $id
     * @return \NetBricks\Page\Component\Photo
     */
    public function setPhotoDocumentId($id)
    {
        $this->options['photo_document_id'] = (string)$id;
        $photo = $this->getRepo()->find($id);
        if ($photo) {
            $this->setPhotoDocument($photo);
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getPhotoDocumentId()
    {
        return (string)@$this->options['photo_document_id'];
    }

}
