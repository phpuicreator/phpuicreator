<?php

namespace button;

class button__view
{
    public $button;
        
    public function __construct($button)
    {
        $this->button = $button;
    }
    
    public function view()
    {
        return <<<EOT
            Ext.create('Ext.Button', {
                text: '{$this->button->getTitle()}',
                handler: function() {
                    alert('You clicked the button!');
                }
            })
       
EOT;
    }
}