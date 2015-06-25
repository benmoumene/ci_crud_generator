<?php

require_once APPPATH . '/libraries/Crud/InputEmail.php';
require_once APPPATH . '/libraries/Crud/InputText.php';
require_once APPPATH . '/libraries/Crud/InputNumber.php';
require_once APPPATH . '/libraries/Crud/InputHidden.php';
require_once APPPATH . '/libraries/Crud/InputCheckbox.php';
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
        $type = ucfirst($sType);
        $class = "Input{$type}";
        return new $class();
    }

}
