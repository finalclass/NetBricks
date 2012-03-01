<?php
/**
 * Author: Sel <s@finalclass.net>
 * Date: 09.11.11
 * Time: 15:20
 */

namespace NetBricks\Admin\Component;

use \NetBricks\Common\Tag;

class Layout extends Tag {

    public $header;
    public $content;

    public function postConstruct() {
        $this->header = new Tag('h2');
        $this->header->setId('header');
        $this->header->setView('Festiwal');
        $this->add($this->header);

        $this->content = new Tag();
        $this->content->setId('content');
        $this->add($this->content);
    }

    public function render() {
        ?>

        <html>
            <head>
                
                <title>Festiwal</title>
            </head>
            <body>
                <?php echo $this->header; ?>
                <hr/>
                <?php echo $this->content; ?>
            </body>
        </html>

        <?php
    }

}

