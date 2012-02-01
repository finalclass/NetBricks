<?php

namespace NetBricks\Common;

use \NetCore\Component\ComponentAbstract;
use \NetCore\Component\Event\ComponentEvent;
use \NetBricks\Event\ContentSwitcherEvent;
use \NetCore\Component\Container;
use \NetCore\Factory\Factory;
use \NetBricks\Facade as _;
use \NetBricks\Common\ContentSwitcher\SwitcherCase;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 15.11.11
 * @time: 14:06
 */
class ContentSwitcher extends Container
{

    /**
     * @var ComponentAbstract
     */
    private $content;

    /**
     * @var \NetBricks\Common\ContentSwitcher\SwitcherCase
     */
    private $selectedCase;

    /**
     * @var string
     */
    private $defaultCase;

    /**
     * @var array
     */
    private $switchPossibilities = array();

    public function __construct($options = array())
    {
        if(!is_array($options)) {
            $options = array($options);
        }
        parent::__construct($options);
    }

    /**
     * @static
     * @param array $options
     * @return \NetBricks\Common\ContentSwitcher\ContentSwitcher
     */
    static public function factory($options = array())
    {
        $class = get_called_class();
        return new $class($options);
    }

    private function resolveContent()
    {
        $this->dispatchEvent(new ContentSwitcherEvent(ContentSwitcherEvent::BEFORE_SWITCH));

        $possibilities = $this->switchPossibilities;
        $this->selectedCase = null;
        foreach($this->getCases() as $case) {
            if(array_search($case->getCaseName(), $possibilities) !== false) {
                $this->selectedCase = $case;
                break;
            }
        }

        if(!$this->selectedCase) {
            $this->selectedCase = $this->getDefaultCase();
        }

        if(!$this->selectedCase) {
            $this->dispatchEvent(new ContentSwitcherEvent(ContentSwitcherEvent::CONTENT_NOT_FOUND));
        } else {
            $className = $this->selectedCase->getContentClassName();
            $this->content = _::loader($className)->create();
            $this->addChild($this->content);
            $this->dispatchEvent(new ContentSwitcherEvent(ContentSwitcherEvent::AFTER_SWITCH, $this->getContent()));
        }
    }

    /**
     * @return SwitcherCase
     */
    public function getSelectedCase()
    {
        return $this->selectedCase;
    }

    public function addCase($caseName, $contentClassName)
    {
        $case = new SwitcherCase($caseName ,$contentClassName);
        $this->options['cases'][$caseName] = $case;
        return $this;
    }

    public function removeCase($caseName)
    {
        unset($this->options['cases'][$caseName]);
        return $this;
    }

    /**
     * @param \NetBricks\Common\ContentSwitcher\SwitcherCase[] $value
     * @return \NetBricks\Common\ContentSwitcher\ContentSwitcher
     */
    public function setCases(array $value)
    {
        $cases = array();
        foreach($value as $key=>$value) {
            if($value instanceof SwitcherCase) {
                $cases[] = $value;
            }
            $cases[] = new SwitcherCase($key, $value);
        }
        $this->options['cases'] = $cases;
        return $this;
    }

    /**
     * @return \NetBricks\Common\ContentSwitcher\SwitcherCase[]
     */
    public function getCases()
    {
        return empty($this->options['cases']) ? array() : $this->options['cases'];
    }

    public function setDefaultCaseName($caseName)
    {
        $cases = $this->getCases();
        $this->defaultCase = isset($cases[$caseName]) ? $cases[$caseName] : null;
        return $this;
    }

    public function getDefaultCase()
    {
        if($this->defaultCase) {
            return $this->defaultCase;
        }
        $arr = $this->getCases();
        return reset($arr);
    }

    public function render()
    {
        echo $this->getContent();
    }

    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string|array $caseNameOrArray You can provide an array of possibilities to switch to.
     * @return ContentSwitcher
     */
    public function switchTo($caseNameOrArray)
    {
        $possibilities = is_array($caseNameOrArray) ? $caseNameOrArray : array($caseNameOrArray) ;
        if(!is_array($caseNameOrArray)) {
            $caseNameOrArray = array($caseNameOrArray);
        }
        $this->dispatchEvent(new ContentSwitcherEvent(ContentSwitcherEvent::BEFORE_POSSIBILITIES_CHANGE));
        $this->switchPossibilities = $possibilities;
        $this->dispatchEvent(new ContentSwitcherEvent(ContentSwitcherEvent::AFTER_POSSIBILITIES_CHANGE));
        $this->resolveContent();
        return $this;
    }
    
}