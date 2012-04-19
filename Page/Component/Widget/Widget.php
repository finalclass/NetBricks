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

namespace NetBricks\Page\Component;

use \NetBricks\Common\Component\Tag;
use \NetBricks\Facade as _;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 15.03.12
 * @time: 13:27
 */
class Widget extends Tag
{

    public function __construct($options = array())
    {
        _::cfg()->getHeader()->getScripts()
                ->prepend('/NetBricks/Common/js/nb.js')
                ->prepend('/NetBricks/Common/js/jquery.js');
        parent::__construct($options);
        $this->setClass($this->getClass() . ' nb_page_widget');
    }

    public function renderDefaultAttributes()
    {
        return $this->renderTagAttributes(array('id', 'class', 'style'));
    }

    public function getJS()
    {
        return file_get_contents(_::loader($this)->find('widget.js')->getFullPath());
    }

    public function render()
    {
        $widgetTypes = _::cfg()->getPage()->getWidget()->getTypes();
        ?>
    <div <?php echo $this->renderDefaultAttributes(); ?>>

        <?php foreach ($widgetTypes as $class => $name): ?>
        <p class="<?php echo $class; ?> widget_type" data-type="<?php echo $class; ?>">
            <?php echo $name; ?>
        </p>
        <?php endforeach; ?>

    </div>
    <?php
    }

}
