<?php

use common\common;

class UI__view
{
    public $ui;
    
    private $_ext_version;
    private $_common;
    // private $_viewport = null;
    
    public function __construct($UI)
    {
        $this->ui = $UI;
        $this->_common = new common;
        
        if($this->ui->debug)
        {
            $this->_ext_version = "ext-all-debug.js" ;
            $this->_ext_theme = "theme-".$this->ui->getSkin()."-debug.js";
            $this->_ext_theme_css = "theme-".$this->ui->getSkin()."-all-debug.css";
        }
        else
        {
            $this->_ext_version = "ext-all.js" ;
            $this->_ext_theme = "theme-".$this->ui->getSkin().".js";
            $this->_ext_theme_css = "theme-".$this->ui->getSkin()."-all.css";
        }
                
    }
    
    public function getView()
    {
        return <<<EOT
            <!DOCTYPE HTML>
            <html manifest="">
            <head>
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

                <title>{$this->ui->getName()}</title>

                <!--Ext-->
                <script type="text/javascript" src="PHPUICreator/libs/extjs/build/{$this->_ext_version}"></script>
                <script type="text/javascript" src="PHPUICreator/libs/extjs/build/classic/theme-{$this->ui->getSkin()}/{$this->_ext_theme}"></script>
                <link rel="stylesheet" type="text/css" href="PHPUICreator/libs/extjs/build/classic/theme-{$this->ui->getSkin()}/resources/{$this->_ext_theme_css}" /> 
                
                <!--Vars-->
                <script type="text/javascript">
                    
                    var version = "{$this->ui->getVersion()}";
                    {$this->ui->getVars()}
                </script>

                <!--Locale-->
                <script type="text/javascript" src="PHPUICreator/libs/extjs/build/classic/locale/locale-{$this->ui->getLanguage()}-debug.js"></script>
                
                <!--APP -->
                <script type="text/javascript">
                    Ext.syncRequire([
                        'Ext.app.Application'
                        
                    ]);
                
                    Ext.application({
                        name: 'PHPUICreator_APP',
                        requires: [
                           
                            
                        ],
                        launch: function() {
                
                            {$this->_common->getJS()}
                
                            var center = {$this->_getVPCenter()}
                            var north = {$this->_getVPNorth()}
                            var south = {$this->_getVPSouth()}
                            var east = {$this->_getVPEast()}
                            var west = {$this->_getVPWest()}
                
                            {$this->ui->getViewport()->getView()}
                        }
                
                    });
                
                </script>
            </head>

            <body></body>
            </html>
        
EOT;
    }
    
    private function _getVPCenter()
    {
        $center = $this->ui->getViewport()->getCenter()->getView();
        
        return $center;
    }
    
    private function _getVPNorth()
    {
        $north = $this->ui->getViewport()->getNorth()->getView();
        
        return $north;
    }
    
    private function _getVPSouth()
    {
        $south = $this->ui->getViewport()->getSouth()->getView();
        
        return $south;
    }
    
    private function _getVPEast()
    {
        $east = $this->ui->getViewport()->getEast()->getView();
        
        return $east;
    }
 
    private function _getVPWest()
    {
        $west = $this->ui->getViewport()->getWest()->getView();
        
        return $west;
    }
}