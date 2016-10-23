<?php

namespace common;

/**
 * Description of common__view
 *
 * @author administrador
 */
class common__view
{
    public function uniqueID()
    {
        return <<<EOT
            function uniqueID()
            {
                return Math.random().toString(36).substring(2, 15) +
                    Math.random().toString(36).substring(2, 15);
            }
EOT;
        
    }
    
    /*public function daterangeVType()
    {
        return <<<EOT
            Ext.apply(Ext.form.VTypes, {
                daterange : function(val, field) {
                    var date = field.parseDate(val);

                    if(!date){
                        return;
                    }
                    if (field.startDateField && (!this.dateRangeMax || (date.getTime() != this.dateRangeMax.getTime()))) {
                        var start = Ext.getCmp(field.startDateField);
                        start.setMaxValue(date);
                        start.validate();
                        this.dateRangeMax = date;
                    } 
                    else if (field.endDateField && (!this.dateRangeMin || (date.getTime() != this.dateRangeMin.getTime()))) {
                        var end = Ext.getCmp(field.endDateField);
                        end.setMinValue(date);
                        end.validate();
                        this.dateRangeMin = date;
                    }
                    /*
                     * Always return true since we're only using this vtype to set the
                     * min/max allowed values (these are tested for after the vtype test)
                     */
                    //return true;
             //   }
            //});
        
//EOT;
   // }
    
    public function passwordVType()
    {
        return <<<EOT
            Ext.apply(Ext.form.VTypes, {
                password : function(val, field) {
                    if (field.initialPassField) {
                        var pwd = Ext.getCmp(field.initialPassField);
                        return (val == pwd.getValue());
                    }
                    return true;
                }
            });
        
EOT;
    }
}
