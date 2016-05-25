<?php

namespace form;

use helpers;

class form__view
{
    public $form;
        
    public function __construct($form)
    {
        $this->form = $form;
    }
    
    public function view()
    {
        return <<<EOT
            Ext.create('Ext.form.Panel', {
                title: '{$this->form->getTitle()}',
                
                url: '{$this->form->model->getUI()->getPHPUICreatorDir()}/bootstrap.php',

                layout: 'anchor',
                defaults: {
                    anchor: '100%'
                },

                // The fields
                defaultType: 'textfield',
                items: [
                    {
                        xtype: 'hidden',
                        name: 'controller',
                        value: '{$this->form->model->getCrudController()}'
                    },
                    {
                        xtype: 'hidden',
                        name: 'method',
                        value: '{$this->form->model->getCrudUpdateMethod()}'
                    },
                    {$this->_prepareFields()}
                ],

                // Reset and Submit buttons
                buttons: [{
                    text: '{$this->form->reset_button_title}',
                    handler: function()
                    {
                        this.up('form').getForm().reset();
                    }
                }, {
                    text: '{$this->form->submit_button_title}',
                    formBind: true,
                    disabled: true,
                    handler: function()
                    {
                        var form = this.up('form').getForm();
                        if (form.isValid())
                        {
                            form.submit({
                                success: function(form, action)
                                {
                                   Ext.Msg.alert('Success', action.result.data.result);
                                },
                                failure: function(form, action)
                                {
                                    Ext.Msg.alert('Failed', action.result.data.result);
                                }
                            });
                        }
                    }
                }
                    {$this->_addExtraButtons()}
                ]
            });
        
EOT;
    }
    
    protected function _addExtraButtons()
    {
        $res = "";
        $buttons_list = $this->form->getButtons();
        foreach($buttons_list as $key => $button)
        {
            if($button->separator())
            {
                $res .= ",'-'";
            }
            
            $res .= ",".$button->getView();
        }
        
        return $res;
    }
    
    protected function _prepareFields()
    {
        $n = 0;
        $res = null;
        $fields = $this->form->model->getFields();
        foreach($fields as $key => $values)
        {
            $allow_blank = helpers::boolToString($values['allow_blank']);
            
            // text, number, date, daterange, code, email, combo, multicombo, select, multiselect
            switch($values['type'])
            {
                case "number":
                   $xtype = "numberfield"; 
                break;
                case "date":
                   $xtype = "datefield";
                break;
                default:
                   $xtype = "textfield";
                break;
            }
            
            $res .= <<<EOT
                {
                    xtype: '{$xtype}',
                    fieldLabel: '{$values['label']}',
                    name: '{$key}',
                    allowBlank: {$allow_blank}
                }
EOT;
            $n++;
            if($n < count($fields))
            {
                $res .= ",";
            }
        }
        
        return $res;
    }
}