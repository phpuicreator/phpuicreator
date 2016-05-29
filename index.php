<?php

require_once 'PHPUICreator/UI.php';

$ui = new UI();
$ui->setDebugMode();
$ui->setPHPUICreatorDir("PHPUICreator");
$ui->setName("Test app");
$ui->setVersion("1.2.3.4");
$ui->setLanguage("ca");
$ui->setSkin('crisp'); // triton, neptune, gray, crisp, classic, aria

$ui->addModel(
    array(
        "name"          => "customers",
        
        "crud"          => array(
            "read"      => "getCustomers", // Using automatic read controller if empty
            "update"    => "setCustomer", // Using automatic update controller if empty
            "delete"    => "removeCustomer" // Using automatic delete controller if empty
        ),
        
        "fields"        => array(
            "groups" => array(
                "test_group_1"   => array(
                    "items" => array(
                        "code"      => array(
                            "type"          => "text", // text, number, date, daterange, code, email, combo, multicombo, select, multiselect
                            "label"         => "", //Using automatic labeling system if empty or not defined
                            "sortable"      => false,
                            "filterable"    => false,
                            "filter_widget" => "", // Could be a previously created widget
                            "allow_blank"   => true // Default is false
                        ),
                        "description" => array(
                            "type"          => "text",
                            "label"         => "", //Using automatic labeling system if empty or not defined
                            "sortable"      => false,
                            "filterable"    => false,
                            "filter_widget" => "",
                            "allow_blank"   => true // Default is false
                        )
                    )
                ),
                "test_group_2"   => array(
                    "items" => array(
                        "order" => array(
                            "type"          => "number", 
                            "label"         => "", //Using automatic labeling system if empty or not defined
                            "sortable"      => false,
                            "filterable"    => false,
                            "filter_widget" => "",
                            "allow_blank"   => true // Default is false
                        ),
                        "date" => array(
                            "type"          => "date", 
                            "label"         => "", //Using automatic labeling system if empty or not defined
                            "sortable"      => false,
                            "filterable"    => false,
                            "filter_widget" => "",
                            "allow_blank"   => true // Default is false
                        ),
                        "daterange" => array(
                            "type"          => "daterange", 
                            "label"         => "", //Using automatic labeling system if empty or not defined
                            "sortable"      => false,
                            "filterable"    => false,
                            "filter_widget" => "",
                            "allow_blank"   => true // Default is false
                        )
                    )
                )
            )
        )
    )
);

$ui->addVar("variable", "69", "int");
$ui->addVar("variable2", "cadena de prueba");

// If we want to customize the model form, we can assign it a new view
// $ui->getModel("customers")->getForm()->setView('custom\custom_customers_form_view');

// Now we get the automatic form and customize submit and reset buttons
$customers_form = $ui->getModel("customers")->getForm();
/*$customers_form->submit_button_title = "Grabar";
$customers_form->reset_button_title = "Limpiar";*/

$new_customers_form_button = $customers_form->addButton("test_form_button");
$new_customers_form_button->toggleSeparator();

// We want the customers form to fill the center region of main viewport
//$ui->getViewport()->setCenter($customers_form);
$ui->getViewport()->setEast($customers_form);

// Render application
$ui->render();