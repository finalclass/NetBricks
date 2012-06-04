<?php
/**
 * Created by JetBrains PhpStorm.
 * User: sel
 * Date: 04.06.12
 * Time: 10:07
 * To change this template use File | Settings | File Templates.
 */

namespace NetBricks\Newsletter\Component;

use \NetBricks\Common\Component\Tag;
use \NetBricks\Common\Component\BasicCrud\Menu;
use \NetBricks\Facade as _;

/**
 * @property \NetBricks\Common\Component\BasicCrud\Menu $menu
 * @property \NetBricks\Common\Component\Container $content
 */
class Management extends Tag
{

    public function __construct($options = array())
    {
        $this->menu = new Menu();
        $this->menu->setParamToSwitch('nb_newsletter_management');

        $this->menu->addButton->setNoRender(true);

        $this->menu->listButton
                ->addData('destination', '.nb_newsletter_management')
                ->addData('component', '\NetBricks\Newsletter\Component\Management\Table');

        switch (_::request()->nb_newsletter_management->toString()) {
            default:
            case 'list':
                $this->content = new \NetBricks\Newsletter\Component\Management\Table();
                break;
            case 'edit':
            case 'add':

                break;
        }

        parent::__construct($options);
    }

    public function render()
    {
        ?>
    <div <?php echo $this->renderTagAttributes($this->getDefaultAttributes()); ?>>
        <?php echo $this->menu; ?>

        <div class="nb_newsletter_management">
            <?php echo $this->content; ?>
        </div>
    </div>
    <?php
    }

}
