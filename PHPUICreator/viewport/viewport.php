<?php

namespace viewport;

use widget\widget;

/*
 * PHPUICreator
 */

/**
 * Define the viewport
 *
 * @author Xavier Piquer
 */
class viewport
{
    private $_center = null;
    private $_north = null;
    private $_south = null;
    private $_east = null;
    private $_west = null;
    private $_center_title = null;
    private $_north_title = null;
    private $_south_title = null;
    private $_east_title = null;
    private $_west_title = null;
    
    private static $instance;
    
    private $_current_view = "viewport\\viewport__view";
    
    public static function getViewport()
    {
        if (null === static::$instance)
        {
            static::$instance = new static();
            static::$instance->_initRegions();
        }
        
        return static::$instance;
    }

    protected function __construct()
    {
        
    }
    
    private function __clone()
    {
    }
    
    private function __wakeup()
    {
    }
    
    public function setCenter($widget)
    {
        $this->setCenterTitle($widget->getTitle());
        $widget->hideTitle();
        $this->_center = $widget;
    }
    
    public function setCenterTitle($title)
    {
        $this->_center_title = $title;
    }
    
    public function setNorth($widget)
    {
        $this->setNorthTitle($widget->getTitle());
        $widget->hideTitle();
        $this->_north = $widget;
    }
    
    public function setNorthTitle($title)
    {
        $this->_north_title = $title;
    }
    
    public function setSouth($widget)
    {
        $this->setSouthTitle($widget->getTitle());
        $widget->hideTitle();
        $this->_south = $widget;
    }
    
    public function setSouthTitle($title)
    {
        $this->_south_title = $title;
    }
    
    public function setEast($widget)
    {
        $this->setEastTitle($widget->getTitle());
        $widget->hideTitle();
        $this->_east = $widget;
    }
    
    public function setEastTitle($title)
    {
        $this->_east_title = $title;
    }
    
    public function setWest($widget)
    {
        $this->setWestTitle($widget->getTitle());
        $widget->hideTitle();
        $this->_west = $widget;
    }
    
    public function setWestTitle($title)
    {
        $this->_west_title = $title;
    }
    
    public function getCenter()
    {
        
        return $this->_center;
    }
    
    public function getCenterTitle()
    {
        
        return $this->_center_title;
    }
    
    public function getNorth()
    {
        
        return $this->_north;
    }
    
    public function getNorthTitle()
    {
        
        return $this->_north_title;
    }
    
    public function getSouth()
    {
        
        return $this->_south;
    }
    
    public function getSouthTitle()
    {
        
        return $this->_south_title;
    }
    
    public function getEast()
    {
        
        return $this->_east;
    }
    
    public function getEastTitle()
    {
        
        return $this->_east_title;
    }
    
    public function getWest()
    {
        
        return $this->_west;
    }
    
    public function getWestTitle()
    {
        
        return $this->_west_title;
    }
    
    private function _initRegions()
    {
        $widget = new widget("dummy_initial_widget");
        
        $this->setCenter($widget);
        $this->setEast($widget);
        $this->setNorth($widget);
        $this->setSouth($widget);
        $this->setWest($widget);
    }
    
    public function setView($class_name)
    {
        $this->_current_view = $class_name;
    }
    
    public function getView()
    {
        $view_object = new $this->_current_view($this);
        
        return $view_object->view();
    }
}
