<?php

namespace NetBricks;

use \NetCore\DependencyInjection\MutualContainer;
use \Doctrine\ORM\Configuration;
use \NetCore\Doctrine\ConnectionOptions;
use \Doctrine\DBAL\Event\Listeners\MysqlSessionInit;
use \Doctrine\ORM\EntityManager;
use \NetCore\Configurable\DynamicObject\Reader;
use \NetCore\Configurable\DynamicObject\Writer;
use \NetBricks\Request;
use \NetBricks\Common\Stage;
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
 * @property EntityManager $em
 * @property \NetBricks\Request $request
 * @property \NetCore\Response $response
 * @property \NetBricks\Common\ContentSwitcher\ContentSwitcher $layout
 * @property \NetCore\Factory\Factory $factory
 * @property \NetBricks\User\Model\CurrentUser $user
 * @property \NetBricks\Factory\Factory $services
 * @property \NetCore\Router\Router $router
 * @property \NetCore\Router\Router $mail
 * @property \NetCore\Loader $loader
 * @property \NetBricks\I18n\Model\Languages $languages
 */
class Facade
{

    static protected $options;

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
        if($resource) {
            $loader->find($resource);
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

    static public function env($value = null)
    {
        if ($value) {
            static::$options[__FUNCTION__] = $value;
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
            set_include_path(get_include_path()
                    . PATH_SEPARATOR . static::sourcePath());

            static::loader()->registerAutoloader();

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
            $options['core']['namespace'] = '\NetCore\Component';
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
     * @return \NetBricks\Request
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

            $r->addRoute('default', '/{stage}/{content}/{action}',
                array(
                    'stage' => 'default',
                    'content' => 'default',
                    'action' => 'default'
                ));
            $r->addRoute('service', '/-{service}');
            $r->addRoute('service_with_id', '/-{service}/{id}');

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
     * @return \Doctrine\ORM\EntityManager
     */
    static public function em()
    {
        if (!isset(static::$options[__FUNCTION__])) {
            $em = EntityManager::create(static::config()->connection->getOptions(), static::config()->doctrine);
            $em->getEventManager()->addEventSubscriber(
                new MysqlSessionInit('utf8', 'utf8_unicode_ci')
            );
            static::$options[__FUNCTION__] = $em;
        }
        return static::$options[__FUNCTION__];
    }

    /**
     * @static
     * @return \NetBricks\Common\ContentSwitcher
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
}