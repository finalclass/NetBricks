<?php

namespace NetBricks\Ini\Component;
use \NetBricks\Facade as _;
use \NetCore\Component\ComponentAbstract;

/**
 * Form for adding variables to INI file
 *
 * Author: MMP
 */
class AddForm extends ComponentAbstract {

    public function render() {

        $arr = parse_ini_file(_::sourcePath() .
                "/../var/config.ini");
        ?>

        <HTML>
            <head>
                <meta charset="UTF-8"/>
            </head>
            <h3><center>PARAMETERS CONFIGURATION</h3></center>
        <div>
            <a href="/config/add">Add variable</a> <a href="/config">List</a><br/><br/>
            <form action="/config/add" method="POST">
                Name:  <input type="text" name="name" value="" /><br/> 
                Value: <input type="text" name="value" value="" /><br/><br/>
                <input type="submit" name="save" value="ADD" />
            </form>
        </div>
        </HTML>
        <?php
    }

}