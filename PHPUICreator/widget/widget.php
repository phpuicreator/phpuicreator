<?php

namespace widget;

/*
 * PHPUICreator
 */

/**
 * Define widget generic class
 *
 * @author Xavier Piquer
 */
class widget
{
    private $_hide_title = false;
    private $_current_view = null;
    
    protected $_title = null;
    
    public $current_view_class = "widget\\widget__view";
    
    public function __construct()
    {
       
    }
    
    public function setView($class_name)
    {
        $this->current_view_class = $class_name;
        $this->_current_view = new $class_name($this);
    }
    
    public function setTitle($title)
    {
        $this->_title = $title;
    }
    
    public function getView()
    {
        if(is_null($this->current_view_class))
        {
            return <<<EOT
                Ext.create('Ext.panel.Panel', {
                    title: '{$this->title}'
                });
EOT;
        }
        else
        {
            return $this->_current_view->view();
        }
        
    }
    
    public function refreshView()
    {
        $this->setView($this->current_view_class);
    }
    
    public function getTitle()
    {
        
        return ($this->_hide_title) ? "" : $this->_title;
    }
    
    public function hideTitle($value = true)
    {
        $this->_hide_title = $value;
        $this->refreshView();
    }
    
    public function isTitleHidden()
    {
        return $this->_hide_title;
    }
}