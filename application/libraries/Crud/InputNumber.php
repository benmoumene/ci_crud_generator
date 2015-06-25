<?php

require_once APPPATH . '/libraries/Crud/InputElement.php';

/**
 * 25/06/2015
 * File: InputNumber.php
 * Encoding: ISO-8859-1
 * Project: ci_crud_generator
 * Description of InputNumber
 *
 * @author Diego Olmedo
 */
class InputNumber extends InputElement
{

    public function __construct()
    {
        parent::__construct();
    }

    public function render($name, $id = "")
    {
        return $this->_render("number", $name, $id = "");
    }

}
