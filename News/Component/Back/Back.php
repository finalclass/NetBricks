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
namespace NetBricks\News\Component;
use \NetBricks\Common\Component\Tag;
use \NetBricks\Common\Component\BasicCrud\Menu;
use \NetBricks\Facade as _;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 29.04.12
 * @time: 12:35
 *
 * @property \NetBricks\Common\Component\BasicCrud\Menu $menu
 * @property \NetBricks\Common\Component\ComponentAbstract $content
 */
class Back extends Tag
{

    public function __construct($options = array())
    {
        parent::__construct($options);
        $this->addClass('nb_news_back');

        $this->menu = new Menu();

        $this->menu->setParamToSwitch('nb_news_back');

        $this->menu->addButton
                ->addData('component', '\NetBricks\News\Component\Back\Form')
                ->addData('destination', '.nb_news_back_container');

        $this->menu->listButton
                ->addData('component', '\NetBricks\News\Component\Back\Table')
                ->addData('destination', '.nb_news_back_container');

        $this->resolveContent();
    }

    private function resolveContent()
    {
        switch(_::request()->nb_news_back->toString()) {
            default:
            case 'list':
                $this->content = new \NetBricks\News\Component\Back\Table();
                break;
            case 'add':
            case 'edit':
                $this->content = new \NetBricks\News\Component\Back\Form();
                break;
        }
    }

    public function render()
    {
        ?>
    <div <?php echo $this->renderTagAttributes($this->getDefaultAttributes()); ?>>

        <?php echo $this->menu; ?>

        <div class="nb_news_back_container">
            <?php echo $this->content; ?>
        </div>

    </div>
        <?php
    }

}
