<?php

namespace daterange;

use widget\widget;

/*
 * PHPUICreator
 */

/**
 * Define a new daterange widget
 *
 * @author Xavier Piquer
 */
class daterange extends widget
{
    public $model = null;
    public $current_view_class = "daterange\\daterange__view";
    
    public function __construct($model, $field_key)
    {
        $this->model = $model;
        
        parent::__construct($field_key, $this->model->getUI());
        
        $this->refreshView();
    }
    
    
    
}
