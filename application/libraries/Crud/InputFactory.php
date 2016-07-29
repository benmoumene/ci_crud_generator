<?php

require_once APPPATH . '/libraries/Crud/InputEmail.php';
require_once APPPATH . '/libraries/Crud/InputText.php';
require_once APPPATH . '/libraries/Crud/InputNumber.php';
require_once APPPATH . '/libraries/Crud/InputHidden.php';
require_once APPPATH . '/libraries/Crud/InputCheckbox.php';
require_once APPPATH . '/libraries/Crud/InputImage.php';

/**
 * 25/06/2015
 * File: InputFactory.php
 * Encoding: ISO-8859-1
 * Project: ci_crud_generator
 * Description of InputFactory
 *
 * @author Diego Olmedo
 */
class InputFactory
{

    public static function crear($sType)
    {
        if (empty($sType)) {
            show_error("No está definido el tipo de Input");
        }
        $type = ucfirst($sType);
        $class = "Input{$type}";
        if ( ! is_file(APPPATH . "/libraries/Crud/{$class}.php")) {
            show_error("No existe la clase <i>" . APPPATH . "/libraries/Crud/{$class}.php</i>");
        }
        return new $class();
    }

}
