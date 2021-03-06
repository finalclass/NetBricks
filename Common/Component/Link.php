<?php

namespace NetBricks\Common\Component;

use \NetBricks\Common\Component\Tag;
use \NetBricks\Facade as _;
use \NetCore\Router\Exception\RouteNotFound;
use \NetCore\Router\Exception as RouterException;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 02.12.11
 * @time: 12:39
 */
class Link extends Tag
{
    private $params = array();

    /**
     * @static
     * @param array $options
     * @return \NetBricks\Common\Component\Link
     */
    static public function factory($options = array())
    {
        $class = get_called_class();
        return new $class($options);
    }

    public function getDefaultAttributes()
    {
        return array('href', 'rel', 'title', 'class', 'style', 'id', 'onclick');
    }

    public function getTagName()
    {
        return 'a';
    }

    public function beforeRender()
    {
        $this->addData('params', \Zend_Json::encode($this->params));
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
        foreach($params as $key=>$val) {
            $this->addParam($key, $val);
        }
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

    public function addCurrentParams()
    {
        $params = _::request()->get->getValue();
        $this->params = array_merge($params, $this->params);
        return $this;
    }

    public function setHref($href)
    {
        $this->options['href'] = (string)$href;
        return $this;
    }

    public function getHref()
    {
        if(isset($this->options['href'])) {
            return $this->options['href'];
        }

        return (string)_::url()->addParams($this->params)
                ->setRouteName($this->getRouteName());
    }

    public function getContent()
    {
        if(!empty($this->options['content'])) {
            return $this->options['content'];
        }
        return (count($this->children) == 0)
                ? $this->getLabel() : parent::getContent();
    }

    /**
     * @param string $value
     * @return \NetBricks\Common\Component\Link
     */
    public function setLabel($value)
    {
        $this->options['label'] = _::translate($value);
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
     * @return \NetBricks\Common\Component\Link
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
     * @return \NetBricks\Common\Component\Link
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
     * @return \NetBricks\Common\Component\Link
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
