<?php

namespace NetBricks;

use \NetCore\Configurable\OptionsAbstract;
use \NetCore\Configurable\DynamicObject\Reader;

/**
 * Author: Szymon Wygnański
 * Date: 06.09.11
 * Time: 18:00
 */
class Request extends Reader
{

    private $params = array();

    private $services = array();
    private $substitutions = array();

    protected $options = array();

    public function __construct(&$params = array())
    {
        parent::__construct($params);
    }

    /**
     * @param string $value
     * @return \NetBricks\Request
     */
    public function setBaseUrl($value)
    {
        $this->options['base_url'] = $value;
        return $this;
    }

    public function isAjax()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH'])
                && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }

    /**
     * @return string
     */
    public function getBaseUrl()
    {
        return empty($this->options['base_url']) ? $this->getBaseUrlFromRequest() : $this->options['base_url'];
    }

    public function getMethod()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function getBaseUrlFromRequest()
    {
        $pageURL = (@$_SERVER['HTTPS'] == 'on') ? 'https://' : 'http://';
        if ($_SERVER['SERVER_PORT'] != '80') {
            $pageURL .= $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'];
        }
        else {
            $pageURL .= $_SERVER['SERVER_NAME'];
        }
        return $pageURL;
    }

    /**
     * @param $params
     * @return \NetBricks\Request
     */
    public function setParams(&$params)
    {
        $this->setTarget($params);
        return $this;
    }

    /**
     * @return bool
     */
    public function isPost()
    {
        return $this->getMethod() == 'post';
    }

    public function isXmlHttpRequest()
    {
        //@TODO Implement this method: isXmlHttpRequest
        throw new \Exception('Not implemented yet!');
    }

    public function getAllParams()
    {
        return $this->target;
    }

    public function getParam($paramName, $defaultValue = '')
    {
        return $this->$paramName->exists() ? $this->$paramName->getValue() : $defaultValue;
    }

    /**
     * @param string $value
     * @return \NetBricks\Request
     */
    public function setUri($value)
    {
        $this->options['uri'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getUri()
    {
        return empty($this->options['uri']) ? $_SERVER['REQUEST_URI'] : $this->options['uri'];
    }

    public function getUriExploded($separator = '/')
    {
        $uri = $this->getUri();
        $questionMarkPosition = strpos($uri, '?');
        if($questionMarkPosition !== false) {
            $uri = substr($uri, 0, $questionMarkPosition);
        }
        return array_values(array_filter(explode($separator, $uri)));
    }

}
