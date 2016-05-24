<?php

namespace widget;

class widget__view
{
    public $widget;
        
    public function __construct($widget)
    {
        $this->widget = $widget;
    }
    
    public function view()
    {
        return <<<EOT
            Ext.create('Ext.panel.Panel', {
                title: '{$this->widget->getTitle()}'
            });
EOT;
    }
}