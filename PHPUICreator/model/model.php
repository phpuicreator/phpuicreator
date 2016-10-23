<?php

namespace model;

use form\form;

/*
 * PHPUICreator
 */

/**
 * Define a new UI model class
 *
 * @author Xavier Piquer
 */
class model
{
    private $_UI = null;
    private $_struct = null;
    private $_view = null;
    private $_forced_fields = array(
        "type", "label", "sortable", "filterable", "filter_widget", "allow_blank"
    );
    private $_form = null;
    private $_grid = null;
    
    public function __construct($struct, $UI)
    {
        $this->_struct = $struct;
        $this->_UI = $UI;
        
        $this->validateFields();
        $this->setControllers();
        
        $this->_form = new form($this);
        // $this->_grid = new grid($this);
        
        $this->applyTranslations();
        
        return $this;
        
    }
    
    public function getUI()
    {
        
        return $this->_UI;
    }
    
    public function getName()
    {
        
        return $this->_struct['name'];
    }
    
    public function getStruct()
    {
        
        return $this->_struct;
    }
    
    public function getFields()
    {
        if(isset($this->_struct['fields']))
        {
            return $this->_struct['fields'];
        }
        else
        {
            return false;
        }
    }
    
    public function getGroups()
    {
        if(isset($this->_struct['fields']['groups']))
        {
            return $this->_struct['fields']['groups'];
        }
        else
        {
            return false;
        }
    }
    
    public function getGroup($group_index)
    {
        if(isset($this->_struct['fields']['groups'][$group_index]))
        {
            return $this->_struct['fields']['groups'][$group_index];
        }
        else
        {
            return false;
        }
    }
            
    
    public function getCrud()
    {
        if(isset($this->_struct['crud']))
        {
            return $this->_struct['crud'];
        }
        else
        {
            return false;
        }
    }
    
    public function getCrudController()
    {
        return $this->_struct['crud_controller'];
    }
    
    public function getCrudUpdateMethod()
    {
        return $this->_struct['crud_update_method'];
    }
    
    public function getCrudReadMethod()
    {
        $this->_struct['crud_read_method'];
    }
    
    public function getCrudDeleteMethod()
    {
        $this->_struct['crud_delete_method'];
    } 
    
    public function getView()
    {
        $this->_view = <<<EOT
            Ext.define('User', {
                extend: 'Ext.data.Model',
                fields: [
                    {$this->_getFieldsView()}
                ]
            });
                
EOT;
        return $this->_view;
    }
    
    protected function _getFieldsView()
    {
        $res = null;
        $n = 0;
        
        foreach($this->getFields() as $ID => $values)
        {
            $res .= "{name: '".$ID."',  type: 'string'}";
            $n++;
            if($n < count($this->getFields()))
            {
                $res .= ", ";
            }
        }
        
        return $res;
    }
    
    public function setName($name = null)
    {
        if(is_null($name))
        {
            throw new Exception('Name parameter can not be empty.');
        }
        
        $this->_struct['name'] = preg_replace('#[^A-Za-z0-9-./]#', '', $name);
    }
    
    public function setControllers()
    {
        $this->_struct['crud_controller'] = "controllers\\\\".$this->getName();
        $this->_struct['crud_read_method'] = "read";
        $this->_struct['crud_update_method'] = "update";
        $this->_struct['crud_delete_method'] = "delete";
        
        if(is_array($this->getCrud()))
        {
            $custom_crud = $this->getCrud();
            /*if(isset($custom_crud['create']) && !empty($custom_crud['create']))
            {
                $this->_struct['crud_create_controller'] = $custom_crud['create'];
            }*/
            if(isset($custom_crud['read']) && !empty($custom_crud['read']))
            {
                $this->_struct['crud_read_method'] = $custom_crud['read'];
            }
            if(isset($custom_crud['update']) && !empty($custom_crud['update']))
            {
                $this->_struct['crud_update_method'] = $custom_crud['update'];
            }
            if(isset($custom_crud['delete']) && !empty($custom_crud['delete']))
            {
                $this->_struct['crud_delete_method'] = $custom_crud['delete'];
            }
        }
    }
    
    public function setFields($data = null)
    {
        if(is_null($data) || !is_array($data))
        {
            throw new Exception('Fields parameter must be an array with values.');
        }
        
        $this->_struct['fields'] = $data;
    }
    
    public function validateFields()
    {
        $fields_list = implode(",", $this->_forced_fields);
        
        foreach($this->getGroups() as $g_group => $group)
        {
            foreach($group['items'] as $key => $value)
            {
                $fields = array_keys($value);

                foreach($this->_forced_fields as $forced_field)
                {            
                    if(!in_array($forced_field, $fields))
                    {
                        throw new \Exception('Mandatory field "'.$forced_field.'" not present in fields section of '.$this->getName().' model. Mandatory fields are: '.$fields_list);
                    }
                }
            }
        }
        
    }
    
    public function applyTranslations()
    {
        $new_groups = array();
        $current_lang = $this->getUI()->getLanguage();
        $lang_controller = 'resources\lang\\'.$current_lang;
        $lang = new $lang_controller;
        
        foreach($this->getGroups() as $g_key => $group)
        {
            $new_values = array();
            $new_groups[$g_key] = $group;
            foreach($group['items'] as $key => $values)
            {
                $new_values[$key] = $values;
                if(isset($values['label']) && empty($values['label']) && isset($lang->trans[$key]))
                {
                    $new_values[$key]['label'] = $lang->trans[$key];
                }
            }
            $new_groups[$g_key]['items'] = $new_values;
        }
        
        $this->_struct['fields']['groups'] = $new_groups;
        
        // Form title
        $form_title_key = "__".$this->_struct['name']."_form_label";
        $form_title = (isset($lang->trans[$form_title_key])) ? $lang->trans[$form_title_key] : $this->_struct['name'];
        if(is_object($this->getForm()))
        {
            $this->getForm()->setTitle($form_title);
        }
        
        // Grid title
        $grid_title_key = "__".$this->_struct['name']."_grid_label";
        $grid_title = (isset($lang->trans[$grid_title_key])) ? $lang->trans[$grid_title_key] : $this->_struct['name'];
        if(is_object($this->getGrid()))
        {
            $this->getGrid()->setTitle($grid_title);
        }
    }
    
    public function getForm()
    {
        
        return $this->_form;
    }
    
    public function getGrid()
    {
        
        return $this->_grid;
    }
}
