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
    private $_UI = null;
    private $_hide_title = false;
    private $_current_view = null;
    
    protected $_name = "";
    protected $_title = "n/a";
    
    public $current_view_class = "widget\\widget__view";
    
    public function __construct($name, $ui = null)
    {
       $this->_UI = $ui;
       $this->_name = $name;
       $this->applyTranslations();
       $this->refreshView();
    }
    
    public function setView($class_name)
    {
        $this->current_view_class = $class_name;
        $this->_current_view = new $class_name($this);
    }
    
    public function setName($name)
    {
        $this->_name = $name;
    }
    
    public function getName()
    {
        return $this->_name;
    }
    
    public function setTitle($title)
    {
        $this->_title = $title;
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
    
    public function getUI()
    {
        return $this->_UI;
    }
    
    public function refreshView()
    {
        $this->setView($this->current_view_class);
    }

    public function applyTranslations()
    {
        if(!is_null($this->_UI))
        {
            $lang = $this->_UI->getTranslations();
            $title = (isset($lang->trans[$this->getName()])) ? $lang->trans[$this->getName()] : "n/a";
            
            $this->setTitle($title);
        }
    }    
}