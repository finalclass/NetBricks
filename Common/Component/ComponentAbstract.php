<?php

namespace NetBricks\Common\Component;

use \NetCore\Configurable\OptionsAbstract;
use \NetCore\Event\ConfigurableEventDispatcher;
use \NetBricks\Common\Component\Event\ComponentEvent;
use \NetCore\Utils\ClassUtils;
use \NetBricks\Facade as _;


/**
 * @author: Szymon Wygnański
 */
abstract class ComponentAbstract extends ConfigurableEventDispatcher
{

    /**
     * @var \NetBricks\Common\Component\Container
     */
    protected $parent;

    /**
     * @var \NetBricks\Common\Component\Container
     */
    protected $root;

    /**
     * @return void
     */
    public function render()
    {

    }

    /**
     * @static
     * @param array $options
     * @return ComponentAbstract
     */
    static public function factory($options = array())
    {
        $class = get_called_class();
        return new $class($options);
    }

    /**
     * @param string $value
     * @return \NetBricks\Common\Component\ComponentAbstract
     */
    public function setSkinPath($value)
    {
        $this->options['skin_path'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getSkinPath()
    {
        return empty($this->options['skin_path']) ? '' : $this->options['skin_path'];
    }

    /**
     * @param string $value
     * @return \NetBricks\Common\Component\ComponentAbstract
     */
    public function setSkin($value)
    {
        $this->options['skin'] = (string)$value;
        return $this;
    }

    /**
     * @return string
     */
    public function getSkin()
    {
        if (empty($this->options['skin'])) {
            return '';
        } else {
            return $this->options['skin'];
        }
    }

    /**
     * @param array $options
     */
    public function __construct($options = array())
    {
        parent::__construct($options);

        $this->dispatchEvent(new ComponentEvent(ComponentEvent::BEFORE_CONSTRUCT));
        $this->construct();
        $this->dispatchEvent(new ComponentEvent(ComponentEvent::AFTER_CONSTRUCT));

        $this->dispatchEvent(new ComponentEvent(ComponentEvent::BEFORE_INITIALIZE));
        $this->init();
        $this->dispatchEvent(new ComponentEvent(ComponentEvent::AFTER_INITIALIZE));
    }

    protected function construct()
    {
    }

    protected function init()
    {
    }

    protected function beforeRender()
    {
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $this->dispatchEvent(new ComponentEvent(ComponentEvent::BEFORE_RENDER));
        $this->beforeRender();
        $view = $this->getView();
        $out = '';
        if ($view) {
            $out .= $this->renderVariable($view);
        } else if (file_exists($this->getSkin())) {
            ob_start();
            include $this->getSkin();
            $out .= ob_get_clean();
        } else {
            $out .= $this->renderVariable(array($this, 'render'));
        }
        $this->dispatchEvent(new ComponentEvent(ComponentEvent::AFTER_RENDER));
        return $out;
    }

    /**
     * @param $value
     * @return \NetBricks\Common\Component\ComponentAbstract
     */
    public function setView($value)
    {
        $this->options['view'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getView()
    {
        return isset($this->options['view']) ? $this->options['view'] : null;
    }

    /**
     * @param \NetBricks\Common\Component\ComponentAbstract|\Closure|string $variable
     * @param null $customArgument
     * @return string
     */
    protected function renderVariable($variable, $customArgument = null)
    {
        return \NetCore\Renderer::renderVariable($variable, $customArgument, $this);
    }

    /**
     * @param Container $parent
     * @return void
     */
    public function setParent(Container $parent)
    {
        $this->dispatchEvent(new ComponentEvent(ComponentEvent::BEFORE_SET_PARENT));
        $this->parent = $parent;
        $stage = $parent->getStage();
        if ($stage) {
            $this->setStage($stage);
        }
        $this->dispatchEvent(new ComponentEvent(ComponentEvent::AFTER_SET_PARENT));
    }

    /**
     * @return Container
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param string $value
     * @return \NetBricks\Common\Component\ComponentAbstract
     */
    public function setStage($value)
    {
        $this->dispatchEvent(new ComponentEvent(ComponentEvent::BEFORE_SET_STAGE));
        $this->options['stage'] = $value;



        $this->addStyleSheets();
        $this->addScripts();

        $this->dispatchEvent(new ComponentEvent(ComponentEvent::AFTER_SET_STAGE));
        return $this;
    }

    private function addStyleSheets()
    {
        $classes = ClassUtils::getAncestorsClassUntil(get_called_class(), __CLASS__);
        $classes[] = get_called_class();
        $styles = _::cfg()->getHeader()->getStyleSheets();
        foreach ($classes as $className) {
            $exploded = explode('\\', $className);
            if (_::loader($className)->find(lcfirst(end($exploded)) . '.css')->exists()) {
                $styles->append(_::loader()->getPath());
            }
        }
    }

    private function addScripts()
    {
        $classes = ClassUtils::getAncestorsClassUntil(get_called_class(), __CLASS__);
        $classes[] = get_called_class();
        $scripts = _::cfg()->getHeader()->getScripts();
        foreach ($classes as $className) {
            $exploded = explode('\\', $className);
            if (_::loader($className)->find(lcfirst(end($exploded)) . '.js')->exists()) {
                $scripts->append(_::loader()->getPath());
            }
        }
    }


    /**
     * @return string
     */
    public function getStage()
    {
        return empty($this->options['stage']) ? '' : $this->options['stage'];
    }

    /**
     * @return \NetBricks\Common\Component\Container
     */
    public function getRoot()
    {
        return $this->parent ? $this->parent->getRoot() : $this;
    }

    /**
     * @return \NetBricks\Common\Component\ComponentAbstract[]
     */
    public function getParents()
    {
        $parents = array();
        for ($parent = $this->getParent(); $parent !== null; $parent = $parent->getParent()) {
            $parents[] = $parent;
        }
        return $parents;
    }

    /**
     * @param $type
     * @return \NetBricks\Common\Component\ComponentAbstract[]
     */
    public function getParentsByType($type)
    {
        $parents = array();
        for ($parent = $this->getParent(); $parent !== null; $parent = $parent->getParent()) {
            if ($parent instanceof $type) {
                $parents[] = $parent;
            }
        }

        return $parents;
    }

}
