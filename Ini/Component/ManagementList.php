<?php

/**
 * ManagementList - configuration's panel
 *
 * Author: MMP
 */

namespace NetBricks\Ini\Component;

use \NetBricks\Common\Component\ComponentAbstract;
use \NetBricks\Common\Component\Container;
use \NetBricks\Ini\Model\ConfigModel;

/**
 * Class that displays configuration's panel in HTML way
 */
class ManagementList extends Container {

    public function __construct($options = array()) {
        parent::__construct($options);
    }

    public function invalidateChildren()
    {
        $configModel = new ConfigModel($this->getFilePath());
        

        $this->removeAllChildren();
        
        if (!empty($_GET['remove_by_key'])) {
            $key = $_GET['remove_by_key'];
            unset($configModel->$key);
            $configModel->save();
        }

        if ((!empty($_POST)) && (!empty($_POST['config']))) {
            $varName = $_POST['config']['key'];
            $varValue = $_POST['config']['value'];
            $oldKey = $_POST['config']['oldKey'];

            unset($configModel->$oldKey);

            if (!empty($varName) && !empty($varValue)) {

                $configModel->$varName = $varValue;
                $configModel->save();
            }
        } else if (!empty($_GET['createEmptyField'])) {
            $this->addChild(HorizontalForm::factory());
        }
        
        foreach ($configModel as $key => $value) {
            $this->addChild(HorizontalForm::factory()->setValue($value)
                            ->setKey($key));
        }
    }
    
    
    public function setFilePath($value) {
        $this->options['file_path'] = $value;
        $this->invalidateChildren();
        return $this;
    }

    public function getFilePath() {
        return $this->options['file_path'];
    }

}