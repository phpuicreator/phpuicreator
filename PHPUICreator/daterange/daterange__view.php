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
        
    public function __construct($daterange)
    {
        $this->daterange = $daterange;
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
                        name: 'startdt',
                        itemId: 'startdtID',
                        vtype: 'daterange',
                        //endDateField: this.down('[itemId=enddtID]')
                    },{
                        xtype: 'datefield',
                        fieldLabel: '{$this->_getEndDateLabel()}',
                        name: 'enddt',
                        itemId: 'enddtID',
                        vtype: 'daterange',
                        //startDateField: this.down('[itemId=startdtID]')
                    }]
            })
EOT;
    }
    
    private function _getStartDateLabel()
    {
        $lang = $this->daterange->getUI()->getTranslations();
        return (isset($lang->reserved_trans["__daterange_start_date"])) ? $lang->reserved_trans["__daterange_start_date"] : "n/a";
            
    }
    
    private function _getEndDateLabel()
    {
        $lang = $this->daterange->getUI()->getTranslations();
        return (isset($lang->reserved_trans["__daterange_end_date"])) ? $lang->reserved_trans["__daterange_end_date"] : "n/a";
            
    }
    
}
