<?php
/**

Copyright (C) Szymon Wygnanski (s@finalclass.net)

Permission is hereby granted, free of charge, to any person obtaining a copy of
this software and associated documentation files (the "Software"), to deal in
the Software without restriction, including without limitation the rights to
use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies
of the Software, and to permit persons to whom the Software is furnished to do
so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
 */

namespace NetBricks\Common;

use \NetBricks\Facade as _;
use \NetCore\Router\Exception\RouteNotFound;
use \NetCore\Router\Exception as RouterException;
use \NetCore\Configurable\OptionsAbstract;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 04.03.12
 * @time: 11:07
 */
class UrlBuilder extends OptionsAbstract
{

    private $params = array();
    protected $options = array();

    public function __construct($urlOrOptions = array())
    {
        if(is_string($urlOrOptions)) {
            $this->url = $urlOrOptions;
        } else if(is_array($urlOrOptions) && !empty($urlOrOptions)) {
            $this->setOptions($urlOrOptions);
        }
    }

    /**
     * @param string $value
     * @return \NetBricks\Common\UrlBuilder
     */
    public function setUrl($value)
    {
        $this->options['url'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return empty($this->options['url']) ? '' : $this->options['url'];
    }

    public function addCurrentParams()
    {
        $params = _::request()->get->getValue();
        $this->params = array_merge($params, $this->params);
        return $this;
    }

    public function addParam($paramName, $value)
    {
        $this->params[$paramName] = $value;
        return $this;
    }

    public function removeParam($paramName)
    {
        unset($this->params[$paramName]);
        return $this;
    }

    public function addParams(array $params)
    {
        $this->params = array_merge($this->params, $params);
        return $this;
    }

    public function getParam($paramName)
    {
        return (string)@$this->params[$paramName];
    }

    /**
     * @param string $value
     * @return \NetBricks\Common\Component\Link
     */
    public function setRouteName($value)
    {
        $this->options['route_name'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getRouteName()
    {
        return empty($this->options['route_name']) ? 'default' : $this->options['route_name'];
    }

    public function __toString()
    {
        if($this->getUrl()) {
            return $this->getUrl();
        }

        try {
            $route = _::router()->getRoute($this->getRouteName());
            $params = array_merge(_::request()->get->getArray(), $this->params);
            if (!$route) {
                $route = _::router()->findRoute($params);
            }

            if (!$route) {
                throw new RouteNotFound();
            }

            return _::request()->getBaseUrl()
                    . ltrim($route->buildUri($this->params, _::request()->get->getArray()), '/');

        } catch (RouterException $e) {
            $params = @(array)http_build_query($this->params, '&amp');
            return _::request()->getBaseUrl() . '?' . join('&', $params);
        }
    }

    public function encode()
    {
        return urlencode((string)$this);
    }

    public function redirect()
    {
        header('Location: ' . (string)$this);
        exit;
    }

}
