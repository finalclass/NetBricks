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
namespace NetBricks\Page\Component\Photo\Management\ManageMany;
use \NetBricks\Common\Component\Tag;
use \NetBricks\Facade as _;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 08.05.12
 * @time: 15:28
 *
 * @property \NetBricks\Page\Component\Photo\Thumb $img
 * @property \NetBricks\Common\Component\IconLink $editButton
 * @property \NetBricks\Common\Component\IconLink $removeButton
 */
class PhotoBox extends Tag
{

    public function __construct($options = array())
    {
        parent::__construct($options);

        $this->addClass('nb_page_photo_management_photo_box');

        _::cfg()->getHeader()->getStyleSheets()->addJQueryUi()->addNetBricks();

        $this->img = new \NetBricks\Page\Component\Photo\Thumb();
        $this->editButton = new \NetBricks\Common\Component\IconLink();
        $this->removeButton = new \NetBricks\Common\Component\IconLink();

        $this->editButton->setIconClass('ui-icon ui-icon-pencil')
                ->addParam('action', 'edit')
                ->setLabel('nb_page_photo_edit')
                ->addClass('nb-button ui-state-default ui-corner-all');

        $this->removeButton->setIconClass('ui-icon ui-icon-trash')
                ->setLabel('nb_page_photo_remove')
                ->setOnclick("return confirm('" . _::translate('nb_page_photo_remove_confirm') . "');")
                ->addClass('nb-button ui-state-default ui-corner-all remove');
    }

    /**
     * @param \NetBricks\Page\Document\Photo $value
     * @return \NetBricks\Page\Component\Photo\Management\ManageMany\PhotoBox
     */
    public function setDocument($value)
    {
        $this->options['document'] = $value;
        $this->img->setPhotoDocument($value);
        $this->editButton->addParam('id', $value->getId());

        $this->removeButton
                ->addParam('service', 'photo-delete')
                ->addParam('id', $value->getId())
                ->addParam('rev', $value->getRev());
        return $this;
    }

    /**
     * @return \NetBricks\Page\Document\Photo
     */
    public function getDocument()
    {
        return @$this->options['document'];
    }

    public function render()
    {
        ?>
    <div <?php echo $this->renderTagAttributes($this->getDefaultAttributes()); ?>>

        <div class="img" style="height: <?php echo _::cfg()->getPage()->getPhoto()->getThumbHeight();?>px">
            <?php echo $this->img; ?>
        </div>

        <ul class="operations">
            <li>
                <?php echo $this->editButton; ?>
            </li>
            <li>
                <?php echo $this->removeButton; ?>
            </li>
        </ul>

    </div>
    <?php
    }

}
