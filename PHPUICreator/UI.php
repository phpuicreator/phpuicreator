<?php

use model\model;

use viewport\viewport;

/**
 * PHPUICreator Main Class
 *
 * @author Xavier Piquer
 */
class UI
{
    private $_name = "PHPUICreator";
    private $_dir = "PHPUICreator";
    private $_version = "1.0.0.0";
    private $_viewport = null;
    private $_models = array();
    private $_supported_languages = array(
        "en"    => "English",
        "ca"    => "Català",
        "es"    => "Español"
    );
    private $_ui_language = "es";
    private $_ui_skin = 'triton';
    private $_ui_vars = array();
    
    protected $_translations = null;
    
    public $debug = false;
    public $tmp = "/tmp";
    
    public function __construct($language_code = null)
    {
        spl_autoload_register(function ($raw_class)
        {
            $class = strtr($raw_class, array("\\" => "/"));
            $file = __DIR__."/".$class.".php";
            $alternate_file = strtr($file, array($this->getPHPUICreatorDir()."/" => ""));

            if(is_readable($file))
            {
                require_once $file;
            }
            else
            {
                $file = $alternate_file;
                if(is_readable($file))
                {
                    require_once $file;
                }
                else
                {
                    \helpers::sayKo("Class [".$file."] does'nt exist.");
                    die();
                }
            }
        });
        
        if(!is_null($language_code))
        {
            $this->setLanguage($language_code);
        }
        
        $lang_controller = 'resources\lang\\'.$this->getLanguage();
        $this->_translations = new $lang_controller;
    }
    
    public function setDebugMode($enabled = true)
    {
        $this->debug = $enabled;
        
        $_SESSION['PHPUICreatorDebugMode'] = $this->debug;
    }
    
    public function setSkin($skin)
    {
        $this->_ui_skin = $skin;
    }
    
    public function setPHPUICreatorDir($dir)
    {
        $this->_dir = $dir;
    }
    
    public function setName($name)
    {
        $this->_name = $name;
    }
    
    public function setVersion($version)
    {
        $this->_version = $version;
    }
    
    public function setLanguage($language_code = null)
    {
        if(!is_null($language_code) && key_exists($language_code, $this->_supported_languages))
        {
            $this->_ui_language = $language_code;
            $lang_controller = 'resources\lang\\'.$this->getLanguage();
            $this->_translations = new $lang_controller;
            
            return true;
        }
        else
        {
            throw new \Exception('Language is not supported.');
        }
    }
    
    public function getVersion()
    {
        return $this->_version;
    }
    
    public function getPHPUICreatorDir()
    {
        return $this->_dir;
    }
    
    public function getTranslations()
    {
        return $this->_translations;
    }
    
    public function addVar($var_name, $var_value, $var_type = "string")
    {
        $this->_ui_vars[] = array(
            "name"  => $var_name,
            "value" => $var_value,
            "type"  => $var_type
        );
        
        return true;
    }
    
    public function getVars()
    {
        $res = null;
        
        foreach($this->_ui_vars as $key => $values)
        {
            $var_val = '"'.$values['value'].'"';
            if($values['type'] == "int" && is_numeric($values['value']))
            {
                $var_val = $values['value'];
            }
            
            $res .= "var ".$values['name']." = ".$var_val.";".PHP_EOL;
        }
        
        return $res;
    }
    
    public function getSkin()
    {
        
        return $this->_ui_skin;
    }
    
    public function getLanguage()
    {
        
        return $this->_ui_language;
    }
    
    public function getName()
    {
        
        return $this->_name;
    }
    
    public function addModel($struct)
    {
        if(!is_object($struct) && !is_array($struct))
        {
            throw new \Exception('Struct passed is not an array or stdClass.');
        }
        
        if(is_object($struct))
        {
            $struct = json_encode($struct, true);
        }
        
        $this->_models[$struct['name']] = new model($struct, $this);
        
        return true;
    }
    
    public function getModel($model_name)
    {
        
        return $this->_models[$model_name];
    }
    
    public function getModels()
    {
        
        return $this->_models;
    }
    
    public function getViewport()
    {
        $this->_viewport = viewport::getViewport($this);
        
        return $this->_viewport;
    }
    
    public function render()
    {
        $view = new UI__view($this);
        
        echo $view->getView();
        
        $this->resetTmpFiles();
        
        return true;
    }
    
    public function resetTmpFiles()
    {
        unlink($this->tmp."/daterange");
    }
}