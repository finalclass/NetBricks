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

use \NetBricks\Common\Component\Container;
use \NetBricks\Common\Component\BasicCrud\Menu;
use \NetBricks\Facade as _;


/**
 * @author: Sel <s@finalclass.net>
 * @date: 04.03.12
 * @time: 15:37
 *
 * @property \NetBricks\Common\Component\BasicCrud\Menu $menu
 * @property \NetBricks\Common\Component\Container $content
 */
class Layout extends Container
{

    public function __construct($options = array())
    {
        $this->menu = _::loader('\NetBricks\Common\Component\BasicCrud\Menu')->create();

        switch(_::request()->action->getString()) {
            default:
            case 'list':
                $this->content = _::loader($this)->find('../ManageMany')->create();
                break;
            case 'edit':
            case 'add':
            $this->content = _::loader($this)->find('../Form')->create();
                break;
        }

        parent::__construct($options);
    }

    public function render()
    {
        ?>
<div class="photo_management">
    <?php echo $this->menu; ?>
    <?php echo $this->content; ?>
</div>
        <?php
    }

}
