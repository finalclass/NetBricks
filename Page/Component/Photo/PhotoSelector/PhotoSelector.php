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
use \NetBricks\Common\Component\Tag;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 24.04.12
 * @time: 13:16
 *
 * @property \NetBricks\Page\Component\Photo\Management\Form $photoForm
 * @property HorizontalGallery $horizontalGallery
 */
class PhotoSelector extends Tag
{

    public function __construct($options = array())
    {
        parent::__construct($options);
        $this->photoForm = new \NetBricks\Page\Component\Photo\Management\Form();
        $this->horizontalGallery = new HorizontalGallery();
        $this->addClass('nb_page_photo_selector');
    }

    public function render()
    {
        ?>
    <div <?php echo $this->renderTagAttributes($this->getDefaultAttributes()); ?>>

        <iframe src="/?stage=/NetBricks/Page/Component/Photo/UploaderPage" frameborder="0"></iframe>

        <hr/>
        <h3>Or select an existing photo</h3>
        <?php echo $this->horizontalGallery; ?>

    </div>
        <?php
    }



}
