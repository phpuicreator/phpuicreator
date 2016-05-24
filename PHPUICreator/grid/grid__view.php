<?php

class form__view
{
    public $ui;
    
    public function __construct($UI)
    {
        $this->ui = $UI;
    }
    
    public function getView()
    {
        return <<<EOT
            
        
EOT;
    }
}