<?php

namespace NetBricks\Article\Component;

use \NetBricks\Article\Model\ArticleModel;
use \NetBricks\Common\Container;
use \NetBricks\Common\ContentSwitcher;
use \NetBricks\Common\RelativeLink;
use \NetBricks\Facade as _;

/**
 * Layout for Article
 *
 * Author: MMP
 *
 * @property \NetBricks\Common\IconLink $add
 * @property \NetBricks\Common\IconLink $list
 */
class ManagementLayout extends Container {

    public function __construct() {
        parent::__construct();

        $f = _::factory()->netBricks->common;

        $this->add = $f->iconLink()->addParam('action', 'form')->setLabel('Dodaj');
        $this->list = $f->iconLink()->addParam('action', 'list')->setLabel('Lista');

        //$this->a = new ArticleModel();
        $this->setContent(ContentSwitcher::factory()
                        ->addCase('form', '\NetBricks\Article\Component\ArticleForm')
                        ->addCase('list', '\NetBricks\Article\Component\Management\Table')
                        ->addCase('erase', '\NetBricks\Article\Component\ArticleEraser')
                        ->setDefaultCaseName('list')
        );
        
        $this->getContent()->switchTo(_::request()->getUriExploded());
        
    }

    public function setContent(ContentSwitcher $value) {

        $this->options['content'] = $value;
        $this->addChild($value);
        return $this;
    }
    
    public function getContent()
    {
        return $this->options['content'];
    }
    

    public function render() {
            ?>
<h2>Articles</h2>
<ul class="buttons">
    <li>
        <?php echo $this->add->setIconClass('ui-icon ui-icon-plus'); ?>
    </li>
    <li>
        <?php echo $this->list->setIconClass('ui-icon ui-icon-folder-open'); ?>
    </li>
</ul>
<?php echo $this->getContent(); ?>
        <?php
    }

}