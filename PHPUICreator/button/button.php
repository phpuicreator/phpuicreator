<?php

namespace button;

use widget\widget;

/*
 * PHPUICreator
 */

/**
 * Define a new button
 *
 * @author Xavier Piquer
 */
class button extends widget
{
    private $_separator = false;
    private $_handler = array();
    
    public $current_view_class = "button\\button__view";
    
    public function __construct($name, $ui = null)
    {
        parent::__construct($name, $ui);
        
        $struct = array(
            "controller"    => "controllers\\\\".$this->getName(),
            "method"        => $this->getName()."__click",
            "timeout"       => 60000,
            "js_script"     => ""
        );
        $this->setHandler($struct);
    }
    
    public function setHandler($struct)
    {
        $this->_handler = $struct;
    }
    
    public function getHandler()
    {
        return $this->_handler;
    }
    
    public function toggleSeparator()
    {
        $this->_separator = !$this->_separator;
    }
    
    public function separator()
    {
        return $this->_separator;
    }
}
