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
    public $ui;
        
    public function __construct($ui)
    {
        $this->ui = $ui;
    }
    
    public function view()
    {
        return <<<EOT
            var startdtID = uniqueID();
            var enddtID = uniqueID();
        
            Ext.create('Ext.form.FieldSet', {
                title: 'Date Range',
                items: [
                    {
                        xtype: 'datefield',
                        fieldLabel: 'Start Date',
                        name: 'startdt',
                        id: startdtID,
                        vtype: 'daterange',
                        endDateField: enddtID // id of the end date field
                    },{
                        fieldLabel: 'End Date',
                        name: 'enddt',
                        id: enddtID,
                        vtype: 'daterange',
                        startDateField: startdtID // id of the start date field
                    }]
            })
EOT;
    }
    
}
