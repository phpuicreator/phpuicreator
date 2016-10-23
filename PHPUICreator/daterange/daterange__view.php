<?php

namespace daterange;

/*
 * PHPUICreator
 */

/**
 * Define a new daterange view
 *
 * @author Xavier Piquer
 */

class daterange__view
{
    public $daterange;
    public $key;
    public $start_date_id;
    public $end_date_id;
        
    public function __construct($daterange)
    {
        $this->daterange = $daterange;
        $this->start_date_id = $this->_getStartDateName();
        $this->end_date_id = $this->_getEndDateName();
        $this->_setCounter();
    }
    
    public function view()
    {
        return <<<EOT
            
            Ext.create('Ext.form.FieldSet', {
                title: '{$this->daterange->getTitle()}',
                items: [
                    {
                        xtype: 'datefield',
                        fieldLabel: '{$this->_getStartDateLabel()}',
                        name: '{$this->start_date_id}',
                        id: '{$this->start_date_id}',
                    },{
                        xtype: 'datefield',
                        fieldLabel: '{$this->_getEndDateLabel()}',
                        name: '{$this->end_date_id}',
                        id: '{$this->end_date_id}',
                    }]
            })
EOT;
    }
    
    protected function _getStartDateLabel()
    {
        $lang = $this->daterange->getUI()->getTranslations();
        return (isset($lang->reserved_trans["__daterange_start_date"])) ? $lang->reserved_trans["__daterange_start_date"] : "n/a";
            
    }
    
    protected function _getEndDateLabel()
    {
        $lang = $this->daterange->getUI()->getTranslations();
        return (isset($lang->reserved_trans["__daterange_end_date"])) ? $lang->reserved_trans["__daterange_end_date"] : "n/a";
            
    }
    
    protected function _setCounter()
    {
        $tmp_dir = $this->daterange->getUI()->tmp;
        $daterange_tmp_file = $tmp_dir."/daterange";
        
        \file_put_contents($daterange_tmp_file, "0");
    }
    
    protected function _getCounter()
    {
        $tmp_dir = $this->daterange->getUI()->tmp;
        $daterange_tmp_file = $tmp_dir."/daterange";
        /*if(!is_dir($tmp_dir));
        {
            throw new \Exception($tmp_dir.' directory does\'nt exist. Please, be sure the directory exists and is writable by webserver user.');
        }*/
        
        if(!file_exists($daterange_tmp_file))
        {
            touch($daterange_tmp_file);
            $counter = 0;
        }
        else
        {
             $counter = \file_get_contents($daterange_tmp_file);
        }
        
        return $counter;
    }
    
    protected function _getStartDateName()
    {
        $counter = $this->_getCounter() + 1;
        return $this->daterange->getName()."_start_".$counter;
    }
    
    protected function _getEndDateName()
    {
        $counter = $this->_getCounter() + 1;
        return $this->daterange->getName()."_end_".$counter; 
    }
    
}
