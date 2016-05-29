<?php

namespace form;

use helpers;
use daterange\daterange;

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
        $g = 0;
        $res = null;
        $groups = $this->form->model->getGroups();
        foreach($groups as $g_key => $group)
        {
            $n = 0;
            
            $res .= <<<EOT
                {
                    xtype:'fieldset',
                    columnWidth: 0.5,
                    title: 'prova', // TODO: translage $g_key as trans key
                    collapsible: true,
                    defaultType: 'textfield',
                    defaults: {anchor: '100%'},
                    layout: 'anchor',
                    items :[
                    
EOT;
            foreach($group['items'] as $key => $field)
            {
                $std = true;
                $allow_blank = helpers::boolToString($field['allow_blank']);

                // text, number, date, daterange, code, email, combo, multicombo, select, multiselect
                switch($field['type'])
                {
                    case "number":
                       $xtype = "numberfield"; 
                    break;
                    case "date":
                       $xtype = "datefield";
                    break;
                    case "daterange":
                        $daterange = new daterange($this->form->model, $key);
                        $res .= $daterange->getView();
                        $std = false;
                    break;
                    default:
                       $xtype = "textfield";
                    break;
                }

                if($std)
                {
                    $res .= <<<EOT
                        {
                            xtype: '{$xtype}',
                            fieldLabel: '{$field['label']}',
                            name: '{$key}',
                            allowBlank: {$allow_blank}
                        }
EOT;
                }
                $n++;
                if($n < count($group['items']))
                {
                    $res .= ",";
                }
            }
            
            $res .= "]}";
            $g++;
            if($g < count($groups))
            {
                $res .= ",";
            }
        }
        
        return $res;
    }
}