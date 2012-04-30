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
use \NetBricks\Common\Component\Document\Html5;
use \NetBricks\Facade as _;
/**
 * @author: Sel <s@finalclass.net>
 * @date: 24.04.12
 * @time: 13:50
 */
class UploaderPage extends Html5
{

    public function __construct($options = array())
    {
        _::cfg()->getHeader()->getStyleSheets()->addJQueryUi();
        parent::__construct($options);
    }

    public function init()
    {
        switch(_::request()->action->toString()) {
            case 'list':
                $this->body->addChild(new \NetBricks\Page\Component\Photo\UploaderPage\UploadComplete());
                break;
            default:
            case 'form':
                $form = new \NetBricks\Page\Component\Photo\Management\Form();
                $form->setLegend('Upload photo')
                    ->setSubLegend("Select photo file and set it's name");
                $this->body->addChild($form);

                break;
        }
    }

    public function render()
    {
        ?>
    <div class="ui-widget-content ui-corner-all">
        <?php echo join(PHP_EOL, $this->children); ?>
    </div>
        <?php
    }

}
