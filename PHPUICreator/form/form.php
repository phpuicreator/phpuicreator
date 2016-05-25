<?php

namespace form;

use widget\widget;
use button\button;

/*
 * PHPUICreator
 */

/**
 * Define a new form
 *
 * @author Xavier Piquer
 */
class form extends widget
{
    private $_buttons = array();
    
    public $model = null;
        
    public $submit_button_title = "Submit";
    public $reset_button_title = "Reset";
    public $current_view_class = "form\\form__view";
    
    public function __construct($model)
    {
        $this->model = $model;
        $this->_title = $this->model->getName();
        $this->refreshView();
    }
    
    public function getUI()
    {
        return $this->model->getUI();
    }
    
    public function addButton($name)
    {
        $button = new button($name, $this->getUI());
        $this->_buttons[] = $button;
        
        return $button;
    }
    
    public function getButtons()
    {
        return $this->_buttons;
    }
}
