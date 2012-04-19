<?php

namespace NetBricks\Common\Component;

use \NetBricks\Common\Component\ComponentAbstract;
use \NetBricks\Facade as _;

/**
 * @author: Szymon Wygnański <s@finalclass.net>
 */
class Head extends ComponentAbstract
{


    public function render()
    {
        $cfg = _::cfg()->getHeader();
        ?>
    <head>
        <title><?php echo $cfg->getTitle(); ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=<?php echo $cfg->getCharset(); ?>">
        <meta charset="<?php echo $cfg->getCharset(); ?>">
        <?php foreach($cfg->getScripts()->getUnique() as $file): ?>
        <script type="text/javascript" src="<?php echo $file; ?>"></script>
        <?php endforeach; ?>

        <?php foreach($cfg->getStyleSheets()->getUnique() as $file): ?>
        <link rel="stylesheet" href="<?php echo $file; ?>"/>
        <?php endforeach; ?>
    </head>
        <?php
    }

}
