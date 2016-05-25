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
                    {$this->_renderHandler()}
                }
            })
       
EOT;
    }
    
    protected function _renderHandler()
    {
        $handler = $this->button->getHandler();
        $UI = $this->button->getUI();
        
        $res = <<<EOT
            Ext.Ajax.request({
                url: '{$UI->getPHPUICreatorDir()}/bootstrap.php',
                timeout: {$handler['timeout']},
                method: 'POST',
                params : { controller: '{$handler['controller']}', method: '{$handler['method']}' },
                success: function(response, opts)
                {
                    var obj = Ext.decode(response.responseText);
                    // Ext.Msg.alert('Success', obj);
                },

                failure: function(response, opts)
                {
                    Ext.Msg.alert('Failed', 'Server-side failure with status code ' + response.status);
                }
            });
EOT;
        if(isset($handler['js_script']) && !empty($handler['js_script']))
        {
            $res = $handler['js_script'];
        }
            
        return $res;
    }
}