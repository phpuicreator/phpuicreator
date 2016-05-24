<?php

namespace viewport;

class viewport__view
{
    public $viewport;
    
    public function __construct($viewport)
    {
        $this->viewport = $viewport;
    }
    
    public function view()
    {
        return <<<EOT
            Ext.create('Ext.container.Viewport', {
                defaults: {
                    collapsible: true,
                    split: true,
                    bodyPadding: 5
                },
                layout: 'border',
                items: [
                    {
                        region: 'center',
                        layout: 'fit',
                        title: '{$this->viewport->getCenterTitle()}',
                        items: [center]
                    },
                    {
                        region: 'north',
                        layout: 'fit',
                        title: '{$this->viewport->getNorthTitle()}',
                        items: [north]
                    },
                    {
                        region: 'south',
                        layout: 'fit',
                        title: '{$this->viewport->getSouthTitle()}',
                        items: [south]
                    },
                    {
                        region: 'east',
                        layout: 'fit',
                        title: '{$this->viewport->getEastTitle()}',
                        items: [east]
                    },
                    {
                        region: 'west',
                        layout: 'fit',
                        title: '{$this->viewport->getWestTitle()}',
                        items: [west]
                    }
                ]
            });
        
EOT;
    }
    
}