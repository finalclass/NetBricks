<?php

namespace NetBricks\Common\Component;

use \NetBricks\Common\Component\ComponentAbstract;

/**
 * Author: Sel <s@finalclass.net>
 * Date: 15.11.11
 * Time: 11:41
 */
class Container extends ComponentAbstract
{

    /**
     * @var \NetBricks\Common\Component\ComponentAbstract[]
     */
    protected $children = array();

    public function __construct($options = array())
    {
        parent::__construct($options);
    }

    /**
     * @return string
     */
    public function render()
    {
        $content = $this->getContent();
        if ($content) {
            return $this->renderVariable($content);
        }
        return join(PHP_EOL, $this->children);
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return isset($this->options['content']) ? $this->options['content'] : '';
    }

    /**
     * @param $value
     * @return Tag
     */
    public function setContent($value)
    {
        $this->options['content'] = $value;
        return $this;
    }

    /**
     * @param string $value
     * @return \NetBricks\Common\Component\ComponentAbstract
     */
    public function setStage($value)
    {
        parent::setStage($value);
        foreach ($this->children as $child) {
            $child->setStage($value);
        }
        return $this;
    }

    /**
     * @param ComponentAbstract $child
     * @param string $childName
     * @return Container
     */
    public function addChild(ComponentAbstract $child, $childName = '')
    {
        if (empty($childName)) {
            $this->children[] = $child;
        } else {
            $this->children[$childName] = $child;
        }

        $child->setParent($this);
        return $this;
    }

    public function setChildren(array $children)
    {
        foreach ($children as $childName => $child) {
            $this->addChild($child, $childName);
        }
        return $this;
    }

    public function getChildByName($name)
    {
        return isset($this->children[$name]) ? $this->children[$name] : '';
    }

    public function removeChild($childName)
    {
        if (isset($this->children[$childName])) {
            unset($this->children[$childName]);
        }
        return $this;
    }

    /**
     * @return array|ComponentAbstract[]
     */
    public function getChildren()
    {
        return $this->children;
    }

    public function removeAllChildren()
    {
        $this->children = array();
        return $this;
    }

    public function recursiveDispatchEvent(\NetCore\Event\Event $event)
    {
        foreach ($this->getChildren() as $child) {
            if ($child instanceof Container) {
                $child->recursiveDispatchEvent($event);
            } else if ($child instanceof ComponentAbstract) {
                $child->dispatchEvent($event);
            }
        }
        $this->dispatchEvent($event);
    }

    public function __get($name)
    {
        return isset($this->children[$name]) ? $this->children[$name] : '';
    }

    public function __set($name, $value)
    {
        if ($value instanceof ComponentAbstract) {
            $this->addChild($value, $name);
        } else {
            $this->$name = $value;
        }
    }

    public function __call($name, $arguments)
    {
        if(count($arguments) == 1) {
            $element = $arguments[0];
            $this->$name = $element;
            return $this;
        } else {
            return $this->$name;
        }
    }

}
