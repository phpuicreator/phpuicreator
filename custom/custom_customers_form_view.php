<?php

namespace custom;

use form\form__view;

class custom_customers_form_view extends form__view
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
                bodyPadding: 5,
                
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
                buttons: [/*{
                    text: '{$this->form->reset_button_title}',
                    handler: function()
                    {
                        this.up('form').getForm().reset();
                    }
                }, */{
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
                }]
            });
        
EOT;
    }
}