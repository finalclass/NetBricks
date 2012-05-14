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
use \NetBricks\Common\Component\Image;
use \NetBricks\Common\Component\Link;

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
 * @property \NetBricks\Common\Component\Image $logo
 * @property \NetBricks\Common\Component\Link $logoLink
 * @property \NetBricks\Common\Component\Image $ajaxLoader
 */
class Admin extends Html5
{

    protected $jsParams = array();

    public function __construct($options = array())
    {
        _::cfg()->getHeader()->getScripts()
                ->addJQueryBBQ()
                ->addNetBricks();

        _::cfg()->getHeader()->getStyleSheets()
                ->addNetBricks();

        $params = _::request()->getAllParams();
        unset($params['get']);
        unset($params['post']);

        $this->jsParams = array(
            'params' => $params,
            'animationSpeed' => 300
        );

        $this->menu = new UnorderedList();
        $this->header = Tag::factory()->setTagName('h1');
        $this->footer = Tag::factory()->setTagName('h3');
        $this->quickMenu = new Admin\QuickMenu();
        $this->content = new Container();
        $this->logoLink = Link::factory()->setHref('/admin');
        $this->logo = Image::factory()
                ->setWidth(150)
                ->setHeight(36)
                ->setSrc(_::loader(__CLASS__ . '/NB_logo_D.png'));
        $this->ajaxLoader = Image::factory()
                ->setWidth(100)
                ->setHeight(100)
                ->setSrc(_::loader(__CLASS__ . '/ajax-loader.gif'));


        parent::__construct($options);
        $this->resolveContent();
    }

    private function resolveContent()
    {
        $content = _::request()->content->toString();
        foreach ($this->menu->children as /** @var Link $child */
                 $child) {
            if ($content == $child->getParam('content')) {
                $this->switchContentToMenuItem($child);
                return;
            }
        }

        if (isset($this->menu->children[0])) {
            $this->switchContentToMenuItem($this->menu->children[0]);
        }
    }

    private function switchContentToMenuItem(Link $menuItem)
    {
        $data = $menuItem->getData();
        $this->content = new $data['component']();
    }

    public function addMenuItem($label, $componentName, $contentParamValue = null, $customParams = array())
    {
        if (!$contentParamValue) {
            $contentParamValue = $this->generateMenuItemName($componentName);
        }

        $this->menu->$contentParamValue = Link::factory()
                ->addParam('content', $contentParamValue)
                ->addParams($customParams)
                ->setLabel($label)
                ->addData('component', $componentName)
                ->addData('destination', '.nb_layout_admin .content');

        return $this;
    }

    private function generateMenuItemName($componentName, $allNames = array())
    {
        if (empty($allNames)) {
            foreach ($this->menu->children as $child) {
                $allNames[] = $child->getParam('content');
            }
        }

        $paramName = strtolower(join('',
            array_map(
                function($item)
                {
                    return (string)@$item[0];
                },
                explode('\\', $componentName)
            )));

        if (array_search($paramName, $allNames) === false) {
            return $paramName;
        } else {
            return $this->generateMenuItemName($componentName . '\\-', $allNames);
        }
    }

    public function render()
    {
        ?>
    <div class="nb_layout_admin nb-vbox container">
        <?php echo $this->ajaxLoader->addClass('ajax_loader'); ?>
        <div class="nb-hbox top">
            <div class="nb-hbox header">
                <?php echo $this->logoLink
                    ->setTitle('Home')
                    ->setContent($this->logo->setAlt('NetBricks')->addClass('logo')); ?>
                <?php echo $this->header; ?>
            </div>
            <div class="nb-box nb-right">
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
        <div class="nb_layout_admin_data">
            <?php echo \Zend_Json::encode($this->jsParams);?>
        </div>
    </div>
    <?php
    }

}
