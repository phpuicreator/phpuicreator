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
        parent::__construct($this->_title."__form", $model->getUI());
        $this->model = $model;
        $this->_title = $this->model->getName();
        $this->_applyStdButtonsTranslations();
        $this->refreshView();
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
    
    protected function _applyStdButtonsTranslations()
    {
        $lang = $this->model->getUI()->getTranslations();
        $submit_button_title_key = "__".$this->model->getName()."_form_submit_button_label";
        $reset_button_title_key = "__".$this->model->getName()."_form_reset_button_label";
        $this->submit_button_title = (isset($lang->trans[$submit_button_title_key])) ? $lang->trans[$submit_button_title_key] : $this->submit_button_title;
        $this->reset_button_title = (isset($lang->trans[$reset_button_title_key])) ? $lang->trans[$reset_button_title_key] : $this->reset_button_title;
        
    }
}
