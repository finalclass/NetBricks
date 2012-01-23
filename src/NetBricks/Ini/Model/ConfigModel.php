<?php

/**
 * Class ConfigModel 
 *
 * Author: MMP
 */

namespace NetBricks\Ini\Model;

class ConfigModel extends  \Zend_Config_Ini{

    private $fileName;
    
    public function __construct($filename, $section = null, $options = array())
    {
        $this->fileName = $filename;
        $options['allowModifications'] = true;
        parent::__construct($filename, $section, $options);   
    }
    
    public function save() {

        $writer = new \Zend_Config_Writer_Ini(
                array('config' => $this, 
                    'filename' => $this->fileName));
        $writer->write();
    }


}