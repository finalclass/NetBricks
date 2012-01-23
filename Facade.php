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
use \NetBricks\Common\ContentSwitcher\ContentSwitcher;
use \NetCore\Factory\Factory;
use \NetBricks\User\Model\CurrentUser;
use NetCore\Router\Router;

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
 */
class Facade
{

    static private $options;

    /**
     * @static
     * @return \Sel\Mail
     * @throws \Exception
     */
    static public function mail()
    {
        if (!isset(self::$options[__FUNCTION__])) {
            $mailConfig = self::config()->email;
            if (!$mailConfig->exists()) {
                throw new \Exception('config entry: email.* does not exists');
            }
            \Zend_Mail::setDefaultTransport(
                new \Zend_Mail_Transport_Smtp(
                    $mailConfig->smtp->host->getString(),
                    $mailConfig->smtp->options->getArray()));

            self::$options[__FUNCTION__] = 'initialized';
        }
        return new \Sel\Mail();
    }

    static public function env($value = null)
    {
        if ($value) {
            self::$options[__FUNCTION__] = $value;
        }
        if (!isset(self::$options[__FUNCTION__])) {
            self::$options[__FUNCTION__] = 'development';
        }
        return self::$options[__FUNCTION__];
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
        if (!isset(self::$options[__FUNCTION__])) {
            /** @define "self::sourcePath()" "../" */
            set_include_path(get_include_path()
                    . PATH_SEPARATOR . self::sourcePath());
            require_once self::sourcePath() . 'NetCore/AutoLoader.php';
            \NetCore\Autoloader::addIncludePath(self::sourcePath());
            \NetCore\Autoloader::register();

            $application = new \Zend_Application(self::env(), $config);
            self::$options[__FUNCTION__] = $application->bootstrap();
        }
        return self::$options[__FUNCTION__];
    }

    /**
     * @static
     * @return \NetCore\Factory\Factory
     */
    static public function services()
    {
        if (!isset(self::$options[__FUNCTION__])) {
            $s = new Factory(self::config()->services->getArray());
            $s->setRoles(self::user()->getRoles());
            self::$options[__FUNCTION__] = $s;
        }
        return self::$options[__FUNCTION__];
    }

    /**
     * @static
     * @return \NetCore\Event\EventDispatcher
     */
    static public function dispatcher()
    {
        if (!isset(self::$options[__FUNCTION__])) {
            self::$options[__FUNCTION__] = new \NetCore\Event\EventDispatcher();
        }
        return self::$options[__FUNCTION__];
    }

    /**
     * @static
     * @return \NetCore\Factory\Factory
     */
    static public function factory()
    {
        if (!isset(self::$options[__FUNCTION__])) {
            $options = self::config()->factory->getValue();
            if (!isset($options['core']) || !is_array($options['core'])) {
                $options['core'] = array();
            }
            $options['core']['namespace'] = '\NetCore\Component';
            $factory = new Factory($options);
            $factory->setRoles(self::user()->getRoles());
            self::$options[__FUNCTION__] = $factory;
        }
        return self::$options[__FUNCTION__];
    }

    /**
     * @static
     * @return \NetBricks\Request
     */
    static public function request()
    {
        if (!isset(self::$options[__FUNCTION__])) {
            $request = new Request();
            $uri = $_SERVER['REQUEST_URI'];

            $uriWithoutParams = $uri;
            $questionMarkPosition = strpos($uri, '?');
            if ($questionMarkPosition !== false) {
                $uriWithoutParams = substr($uri, 0, $questionMarkPosition);
            }

            $router = self::router();
            $route = $router->findRouteByUri($uri);

            if ($route) {
                $get = array_merge($route->getParamsForUri($uriWithoutParams), $_GET);
                $params = self::createParams($get);
            } else {
                $params = self::createParams($_GET);
            }

            $request->setUri($uri);
            $request->setParams($params);
            self::$options[__FUNCTION__] = $request;
        }

        return self::$options[__FUNCTION__];
    }

    static private function createParams($get, $post = null, $put = null)
    {
        $params = $get;
        $params['get'] = $get;
        switch( strtolower($_SERVER['REQUEST_METHOD']) ) {
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
        if (!isset(self::$options[__FUNCTION__])) {
            $r = new Router();

            $r->addRoute('default', '/{stage}/{content}/{action}',
                array(
                    'stage' => 'default',
                    'content' => 'default',
                    'action' => 'default'
                ));
            $r->addRoute('service', '/-{service}');
            $r->addRoute('service_with_id', '/-{service}/{id}');

            self::$options[__FUNCTION__] = $r;
        }

        return self::$options[__FUNCTION__];
    }

    /**
     * @static
     * @param null $item
     * @return \NetCore\Configurable\DynamicObject\Writer
     */
    static public function session()
    {
        if (!isset(self::$options[__FUNCTION__])) {
            self::$options[__FUNCTION__] = new Writer($_SESSION);
        }
        ;
        return self::$options[__FUNCTION__];
    }

    /**
     * @static
     * @param array $data
     * @param array $data
     * @return \NetCore\Configurable\DynamicObject\Reader
     */
    static public function config($data = array())
    {
        if (!isset(self::$options[__FUNCTION__])) {
            self::$options[__FUNCTION__] = new Reader();
        }
        if ($data) {
            self::$options[__FUNCTION__]->setTarget($data);
        }

        return self::$options[__FUNCTION__];
    }

    /**
     * @static
     * @return \Doctrine\ORM\EntityManager
     */
    static public function em()
    {
        if (!isset(self::$options[__FUNCTION__])) {
            $em = EntityManager::create(static::config()->connection->getOptions(), static::config()->doctrine);
            $em->getEventManager()->addEventSubscriber(
                new MysqlSessionInit('utf8', 'utf8_unicode_ci')
            );
            self::$options[__FUNCTION__] = $em;
        }
        return self::$options[__FUNCTION__];
    }

    /**
     * @static
     * @return \NetBricks\Common\ContentSwitcher\ContentSwitcher
     */
    static public function stage()
    {
        if (!isset(self::$options[__FUNCTION__])) {
            self::$options[__FUNCTION__] = new ContentSwitcher(self::config()->stage->getValue());
        }
        return self::$options[__FUNCTION__];
    }

    /**
     * @static
     * @return \NetBricks\User\Model\CurrentUser
     */
    static public function user()
    {
        if (!isset(self::$options[__FUNCTION__])) {
            self::$options[__FUNCTION__] = \NetBricks\User\Model\CurrentUser::getInstance();
        }
        return self::$options[__FUNCTION__];
    }
}