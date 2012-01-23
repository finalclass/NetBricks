<?php

namespace NetBricks\Common;

use \NetCore\Component\Tag;
use \NetBricks\Facade as _;
use \NetCore\Router\Exception\RouteNotFound;
use NetCore\Router\Exception as RouterException;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 02.12.11
 * @time: 12:39
 */
class Link extends Tag
{
    private $params = array();

    public function getDefaultAttributes()
    {
        return array('href', 'rel', 'title', 'class', 'style', 'id', 'onclick');
    }

    public function getTagName()
    {
        return 'a';
    }

    public function addParam($paramName, $value)
    {
        $this->params[$paramName] = $value;
        return $this;
    }

    /**
     * @param string $value
     * @return \NetBricks\Common\Link
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


    public function addCurrentParams()
    {
        $params = _::request()->get->getValue();
        $this->params = array_merge($params, $this->params);
        return $this;
    }

    public function getHref()
    {
        try {
            $route = _::router()->getRoute($this->getRouteName());
            $params = array_merge(_::request()->get->getArray(), $this->params);
            if(!$route) {
                $route = _::router()->findRoute($params);
            }

            if (!$route) {
                throw new RouteNotFound();
            }
            return _::request()->getBaseUrl()
                    . $route->buildUri($this->params, _::request()->get->getArray());
        } catch (RouterException $e) {
            $params = array();
            foreach ($this->params as $key => $val) {
                $params[] = $key . '=' . $val;
            }
            return _::request()->getBaseUrl() . '?' . join('&', $params);
        }
    }

    public function getContent()
    {
        return (count($this->children) == 0)
                ? $this->getLabel() : parent::getContent();
    }

    /**
     * @param string $value
     * @return \NetBricks\Common\Link
     */
    public function setLabel($value)
    {
        $this->options['label'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return empty($this->options['label']) ? '' : $this->options['label'];
    }

    /**
     * @param string $value
     * @return \NetBricks\Common\Link
     */
    public function setTitle($value)
    {
        $this->options['title'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return empty($this->options['title']) ? $this->getLabel() : $this->options['title'];
    }

    /**
     * @param string $value
     * @return \NetBricks\Common\Link
     */
    public function setRel($value)
    {
        $this->options['rel'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getRel()
    {
        return empty($this->options['rel']) ? '' : $this->options['rel'];
    }

    /**
     * @param string $value
     * @return \NetBricks\Common\Link
     */
    public function setOnclick($value)
    {
        $this->options['onclick'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getOnclick()
    {
        return empty($this->options['onclick']) ? '' : $this->options['onclick'];
    }

}
