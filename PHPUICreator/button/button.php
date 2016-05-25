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
    
    public $current_view_class = "button\\button__view";
    
    public function addHandler()
    {
        
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
