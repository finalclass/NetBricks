<?php

namespace NetBricks;

use \NetBricks\Facade as _;
use \NetBricks\Common\Component\Event\ComponentEvent;
use \NetCore\AutoLoader;
use \NetBricks\Event\BootstrapEvent;

class Bootstrap extends \Zend_Application_Bootstrap_Bootstrap
{

    protected function _initSystem()
    {
        unset($this->_pluginResources['FrontController']);
    }

    protected function _initStaticResources()
    {
        try {
            if (_::loader('/' . $_SERVER['REQUEST_URI'])->isStaticResource()) {
                _::loader()->sendToClient();
            }
        } catch (\NetCore\Loader\Exception\NotAllowed $e) {
            header("HTTP/1.0 403 Forbidden");
            exit;
        }
    }

    protected function _initConfig()
    {
        $cnf = $this->getOptions();
        if (isset($cnf['loader'])) {
            _::loader()->setOptions($cnf['loader']);
        }
        return _::config()->setTarget($cnf);
    }

    protected function _initStaticResource()
    {

    }

    protected function _initSession()
    {
        session_start();
    }

    protected function _initDate()
    {
        if (isset(_::config()->settings->application->datetime)) {
            \date_default_timezone_set(_::config()->settings->application->datetime);
        }
    }

    public function run()
    {

        /**
         * For "get layout" requests:
         * /stage-admin/content-articles/crud-form
         *
         * For "run service" requests:
         * /-article?param1=value1&param2=value2&param3=value3
         */

        $params = _::request()->getAllParams();

        if (isset($params['service'])) {
            @list($serviceName, $method) = explode('-', $params['service']);
            if (empty($method)) {
                $method = _::request()->getMethod();
            }

            $params = _::request()->getAllParams();

            $result = _::services()->$serviceName()->$method($params);
            $response = array();

            if (is_array($result)) {
                if (!isset($result[0])) {
                    $response = $result;
                }
                else if (!empty($result) && is_object(reset($result))) {
                    foreach ($result as $model) {
                        $response[] = is_array($model) ? $model : $model->toArray();
                    }
                } else {
                    $response = $result;
                }
            } else {
                $response = $result->toArray();
            }

            if (isset($params['redirect'])) {
                header('Location: ' . urldecode($params['redirect']));
                exit;
            }

            header('Content-type: application/json');
            echo \Zend_Json::prettyPrint(\Zend_Json::encode($response));
            return;
        }

        $currentStage = _::request()->getParam('stage', 'default');
        if (!empty($currentStage)) {
            try {
                _::dispatcher()->dispatchEvent(new BootstrapEvent(BootstrapEvent::LAYOUT_BEFORE_CONSTRUCTION));
                _::stage()->switchTo($currentStage);
                _::dispatcher()->dispatchEvent(new BootstrapEvent(BootstrapEvent::LAYOUT_AFTER_CONSTRUCTION));

                //Rendering
                _::dispatcher()->dispatchEvent(new BootstrapEvent(BootstrapEvent::LAYOUT_BEFORE_RENDER));
                echo _::stage();
                _::dispatcher()->dispatchEvent(new BootstrapEvent(BootstrapEvent::LAYOUT_AFTER_RENDER));

            } catch (\NetCore\Factory\Exception\NotAllowed $e) {
                //deprecated
                echo _::factory()->netBricks->user->component->login->loginPage();
            } catch (\NetCore\Loader\Exception\NotAllowed $e) {
                echo _::loader('/NetBricks/User/Component/Login/LoginPage')->create();
            }
        }

    }

}