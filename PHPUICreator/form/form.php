<?php

namespace form;

use widget\widget;

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
        $this->model->getParent();
    }
}
