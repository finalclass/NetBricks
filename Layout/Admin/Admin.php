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
namespace NetBricks\Layout;
use \NetBricks\Common\Component\Document\Html5;
use \NetBricks\Common\Component\Container;
use \NetBricks\Common\Component\UnorderedList;
use \NetBricks\Facade as _;
use \NetBricks\Common\Component\Tag;
/**
 * @author: Sel <s@finalclass.net>
 * @date: 24.04.12
 * @time: 20:58
 *
 * @property \NetBricks\Common\Component\UnorderedList $menu
 * @property \NetBricks\Common\Component\Tag $header
 * @property \NetBricks\Layout\Admin\QuickMenu $quickMenu
 * @property \NetBricks\Common\Component\Tag $footer
 * @property \NetBricks\Common\Component\Container $content
 */
class Admin extends Html5
{

    public function __construct($options = array())
    {
        _::cfg()->getHeader()->getStyleSheets()
                    ->setDefaultJqueryUiTheme('netbricks')
                    ->addNetBricks();

        $this->menu = new UnorderedList();
        $this->header = Tag::factory()->setTagName('h1');
        $this->footer = Tag::factory()->setTagName('h3');
        $this->quickMenu = new Admin\QuickMenu();
        $this->content = new Container();

        parent::__construct($options);
    }

    public function render()
    {
        ?>
    <div class="nb-vbox container">
        <div class="nb-hbox top">
            <div class="nb-box header">
                <?php echo $this->header; ?>
            </div>
            <div class="nb-right">
                <?php echo $this->quickMenu->addClass('quick-menu'); ?>
            </div>
        </div>
        <div class="nb-hbox middle">
            <div class="menu">
                <?php echo $this->menu; ?>
            </div>
            <div class="content">
                <?php echo $this->content; ?>
            </div>
        </div>
        <div class="footer">
            <?php echo $this->footer; ?>
        </div>
    </div>
    <?php
    }

}
