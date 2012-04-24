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
use \NetBricks\Common\Component\Form\FormElementAbstract;
use \NetBricks\Facade as _;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 24.04.12
 * @time: 10:16
 */
class PhotosFormElement extends FormElementAbstract
{

    public function __construct($options = array())
    {
        parent::__construct($options);
        $this->addClass('nb_page_photo_form_element');

        _::cfg()->getHeader()->getScripts()
                ->addNetBricks()
                ->addKnockout()
                ->addJQueryWindow();

        _::cfg()->getHeader()->getStyleSheets()
                ->addNetBricks();
    }

    public function render()
    {
        ?>
    <div <?php echo $this->renderTagAttributes($this->getDefaultAttributes()); ?>>

        <div class="data selected_photos"><?php echo \Zend_Json::encode($this->getValue()); ?></div>

        <div class="photos_form">
            <a href="#"
               class="nb-button ui-state-default ui-corner-all"
               data-bind="click: openModalWindow">
                <span class="ui-icon ui-icon-plus"></span>
                Add photo
            </a>
        </div>

        <div data-bind="foreach: selectedPhotos" class="hiddens">
            <input type="hidden" name="<?php echo $this->getName(); ?>[]"
                   data-bind="value: $data"/>
        </div>

        <div data-bind="foreach: selectedPhotos" class="photos">
            <div class="photo">
                <img data-bind="attr: {src: '<?php echo _::couchdb()->getUrl();?>/' + $data + '/thumb.jpg'}">
                <p>
                    <a href="#"
                       class="nb-button ui-state-default ui-corner-all"
                       data-bind="click: $parent.removePhoto">
                        <span class="ui-icon ui-icon-trash"></span>
                        remove
                    </a>
                </p>
            </div>
        </div>

    </div>
    <?php
    }

}
