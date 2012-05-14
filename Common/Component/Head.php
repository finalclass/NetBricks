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
        <?php if(count(_::languages()->getAvailableLanguageCodes()) > 0): ?>
        <meta name="language" content="<?php echo _::languages()->getCurrent(); ?>" />
        <?php endif; ?>

        <meta name="keywords" content="<?php echo $cfg->getKeywords(); ?>"/>
        <meta name="description" content="<?php echo $cfg->getDescription(); ?>"/>

        <?php if($cfg->getRobots()): ?>
        <meta name="robots" content="<?php echo $cfg->getRobots(); ?>" />
        <?php endif; ?>

        <?php if($cfg->getAuthor()): ?>
        <meta name="author" content="<?php echo $cfg->getAuthor(); ?>" />
        <?php endif; ?>

        <meta http-equiv="Content-Type" content="text/html; charset=<?php echo $cfg->getCharset(); ?>">
        <meta charset="<?php echo $cfg->getCharset(); ?>">

        <?php foreach($cfg->getStyleSheets()->getUnique() as $file): ?>
        <link rel="stylesheet" href="<?php echo $file; ?>"/>
        <?php endforeach; ?>

        <?php foreach($cfg->getScripts()->getUnique() as $file): ?>
        <script type="text/javascript" src="<?php echo $file; ?>"></script>
        <?php endforeach; ?>

    </head>
        <?php
    }

}
