<?php

namespace NetBricks;

use \NetCore\DependencyInjection\MutualContainer;
use \NetCore\Configurable\DynamicObject\Reader;
use \NetCore\Configurable\DynamicObject\Writer;
use \NetCore\Request;
use \NetBricks\Common\Component\Stage;
use \NetCore\Factory\Factory;
use \NetBricks\User\Model\CurrentUser;
use NetCore\Router\Router;
use \NetBricks\I18n\Model\Languages;

/**
 * @author: Szymon Wygnański
 * @date: 14.09.11
 * @time: 00:44
 *
 * @property \NetCore\Event\EventDispatcher $dispatcher
 * @property \NetCore\Configurable\DynamicObject\Writer $session
 * @property \NetCore\Configurable\DynamicObject\Reader $config
 * @property \NetCore\Request $request
 * @property \NetCore\Factory\Factory $factory
 * @property \NetBricks\User\Model\CurrentUser $user
 * @property \NetBricks\Factory\Factory $services
 * @property \NetCore\Router\Router $router
 * @property \NetCore\Router\Router $mail
 * @property \NetCore\Loader $loader
 * @property \NetBricks\I18n\Model\Languages $languages
 * @property \NetCore\CouchDB $couchdb
 */
class Facade
{

    static protected $options;

    /**
     * @static
     * @return \NetBricks\Config
     */
    static public function cfg()
    {
        if (!isset(static::$options[__FUNCTION__])) {
            static::$options[__FUNCTION__] = new \NetBricks\Config(static::config()->getArray());
        }
        return static::$options[__FUNCTION__];
    }

    /**
     * @static
     * @return \NetBricks\Common\Component\Header
     */
    /* static public function head()
    {
        if (!isset(static::$options[__FUNCTION__])) {
            static::$options[__FUNCTION__] = static::loader('/NetBricks/Common/Component/Header')->create();
        }
        return static::$options[__FUNCTION__];
    }*/

    /**
     * @static
     * @return \NetCore\CouchDB
     */
    static public function couchdb()
    {
        if (!isset(static::$options[__FUNCTION__])) {
            static::$options[__FUNCTION__] = new \NetCore\CouchDB(static::cfg()->getCouchdb());
        }
        return static::$options[__FUNCTION__];
    }

    /**
     * @static
     * @param string $resource
     * @return \NetCore\Loader
     */
    static public function loader($resource = null)
    {
        if (!isset(static::$options[__FUNCTION__])) {
            require_once realpath(__DIR__ . '/../NetCore/Loader/Loader.php');
            static::$options[__FUNCTION__] = new \NetCore\Loader(__DIR__ . '/../');
        }
        $loader = static::$options[__FUNCTION__];
        if ($resource) {
            $loader->find('/')->find($resource);
        }
        return $loader;
    }

    /**
     * @static
     * @return \Sel\Mail
     * @throws \Exception
     */
    static public function mail()
    {
        if (!isset(static::$options[__FUNCTION__])) {
            $mailConfig = static::config()->email;
            if (!$mailConfig->exists()) {
                throw new \Exception('config entry: email.* does not exists');
            }
            \Zend_Mail::setDefaultTransport(
                new \Zend_Mail_Transport_Smtp(
                    $mailConfig->smtp->host->getString(),
                    $mailConfig->smtp->options->getArray()));

            static::$options[__FUNCTION__] = 'initialized';
        }
        return new \Sel\Mail();
    }

    /**
     * envirement is always lower cased
     * strtolower() is called each time you set the envirement
     *
     * @static
     * @param string $value = null
     * @return mixed
     */
    static public function env($value = null)
    {
        if ($value) {
            static::$options[__FUNCTION__] = strtolower($value);
        }
        if (!isset(static::$options[__FUNCTION__])) {
            static::$options[__FUNCTION__] = 'development';
        }
        return static::$options[__FUNCTION__];
    }

    static public function sourcePath()
    {
        return realpath(__DIR__ . '/../') . '/';
    }

    /**
     * @static
     * @param $config
     * @return \NetBricks\Bootstrap
     */
    static public function bootstrap($config = array())
    {
        if (!isset(static::$options[__FUNCTION__])) {
            /** @define "static::sourcePath()" "../" */
            set_include_path(get_include_path() . PATH_SEPARATOR . static::sourcePath());
            $application = new \Zend_Application(static::env(), $config);
            static::$options[__FUNCTION__] = $application->bootstrap();
        }
        return static::$options[__FUNCTION__];
    }

    /**
     * @static
     * @return \NetCore\Factory\Factory
     */
    static public function services()
    {
        if (!isset(static::$options[__FUNCTION__])) {
            $s = new Factory(static::config()->services->getArray());
            $s->setRoles(static::user()->getRoles());
            $s->component->setNamespace('\NetBricks\Common\ComponentService');
            static::$options[__FUNCTION__] = $s;
        }
        return static::$options[__FUNCTION__];
    }

    /**
     * @static
     * @return \NetCore\Event\EventDispatcher
     */
    static public function dispatcher()
    {
        if (!isset(static::$options[__FUNCTION__])) {
            static::$options[__FUNCTION__] = new \NetCore\Event\EventDispatcher();
        }
        return static::$options[__FUNCTION__];
    }

    /**
     * @static
     * @return \NetCore\Factory\Factory
     */
    static public function factory()
    {
        if (!isset(static::$options[__FUNCTION__])) {
            $options = static::config()->factory->getValue();
            if (!isset($options['core']) || !is_array($options['core'])) {
                $options['core'] = array();
            }
            $options['core']['namespace'] = '\NetBricks\Common\Component';
            $factory = new Factory($options);
            $factory->setRoles(static::user()->getRoles());
            static::$options[__FUNCTION__] = $factory;
        }
        return static::$options[__FUNCTION__];
    }

    /**
     * @static
     * @return \NetBricks\I18n\Model\Languages
     */
    static public function languages()
    {
        if (!isset(static::$options[__FUNCTION__])) {
            $languages = new Languages(static::config()->languages->getArray());
            static::$options[__FUNCTION__] = $languages;
        }
        return static::$options[__FUNCTION__];
    }

    /**
     * @static
     * @return \NetCore\Request
     */
    static public function request()
    {
        if (!isset(static::$options[__FUNCTION__])) {
            $request = new Request();
            $uri = $_SERVER['REQUEST_URI'];

            $uriWithoutParams = $uri;
            $questionMarkPosition = strpos($uri, '?');
            if ($questionMarkPosition !== false) {
                $uriWithoutParams = substr($uri, 0, $questionMarkPosition);
            }

            $router = static::router();
            $route = $router->findRouteByUri($uri);
            if ($route) {
                $get = array_merge($route->getParamsForUri($uriWithoutParams), $_GET);
                $params = static::createParams($get);
            } else {
                $params = static::createParams($_GET);
            }

            $request->setUri($uri);
            $request->setParams($params);
            static::$options[__FUNCTION__] = $request;
        }

        return static::$options[__FUNCTION__];
    }

    static private function createParams($get, $post = null, $put = null)
    {
        $params = $get;
        $params['get'] = $get;
        switch (strtolower($_SERVER['REQUEST_METHOD'])) {
            case 'put':
                parse_str(file_get_contents("php://input"), $putVars);
                $params['put'] = $putVars;
                break;
            default:
            case 'post':
                $params['post'] = $post == null ? $_POST : $post;
                break;
        }
        return $params;
    }

    /**
     * @static
     * @return \NetCore\Router\Router
     */
    static public function router()
    {
        if (!isset(static::$options[__FUNCTION__])) {
            $r = new Router();

            $r->addRoute('service', '/-{service}');
            $r->addRoute('service_with_id', '/-{service}/{id}');
            $r->addRoute('component', '/component={component}',
                array('stage' => '\NetBricks\Common\Component\Document\SingleComponent'));

            $r->addRoute('default', '/{stage}/{content}/{action}',
                array(
                    'stage' => 'default',
                    'content' => 'default',
                    'action' => 'default'
                ));

            static::$options[__FUNCTION__] = $r;
        }

        return static::$options[__FUNCTION__];
    }

    /**
     * @static
     * @return \NetCore\Configurable\DynamicObject\Writer
     */
    static public function session()
    {
        if (!isset(static::$options[__FUNCTION__])) {
            static::$options[__FUNCTION__] = new Writer($_SESSION);
        }
        ;
        return static::$options[__FUNCTION__];
    }

    /**
     * @static
     * @param array $data
     * @param array $data
     * @return \NetCore\Configurable\DynamicObject\Reader
     */
    static public function config($data = array())
    {
        if (!isset(static::$options[__FUNCTION__])) {
            static::$options[__FUNCTION__] = new Reader();
        }
        if ($data) {
            static::$options[__FUNCTION__]->setTarget($data);
        }

        return static::$options[__FUNCTION__];
    }

    /**
     * @static
     * @return \NetBricks\Common\Component\ContentSwitcher
     */
    static public function stage()
    {
        if (!isset(static::$options[__FUNCTION__])) {
            static::$options[__FUNCTION__] = new Stage(static::config()->stage->getValue());
        }
        return static::$options[__FUNCTION__];
    }

    /**
     * @static
     * @return \NetBricks\User\Model\CurrentUser
     */
    static public function user()
    {
        if (!isset(static::$options[__FUNCTION__])) {
            static::$options[__FUNCTION__] = \NetBricks\User\Model\CurrentUser::getInstance();
        }

        return static::$options[__FUNCTION__];
    }

    /**
     * @static
     *
     * @param $string
     * @throws \NetBricks\I18n\Exception\ResourceNotLoaded
     * @return string
     */
    static public function translate($string)
    {
        if (!isset(static::$options[__FUNCTION__])) {
            /**
             * @var \Zend_Translate $translate
             */
            if (\Zend_Registry::isRegistered('Zend_Translate')) {
                $translate = \Zend_Registry::get('Zend_Translate');
            } else {
                $resource = new \NetBricks\I18n\TranslatorResource(
                    self::cfg()->getI18n()->getTranslator()->getOptions());
                $resource->init();
                $translate = \Zend_Registry::get('Zend_Translate');
                if (!$translate) {
                    return $string;
                }

            }
            static::$options[__FUNCTION__] = $translate;
        }
        return static::$options[__FUNCTION__]->translate($string);
    }


    /**
     * @param array $urlOrOptions
     * @return \NetBricks\Common\UrlBuilder
     */
    static public function url($urlOrOptions = array())
    {
        return new \NetBricks\Common\UrlBuilder($urlOrOptions);
    }
}