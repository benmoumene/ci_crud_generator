<?php

require_once APPPATH . '/libraries/Crud/InputElement.php';

/**
 * 25/06/2015
 * File: InputCheckbox.php
 * Encoding: ISO-8859-1
 * Project: ci_crud_generator
 * Description of InputEmail
 *
 * @author Diego Olmedo
 */
class InputCheckbox extends InputElement
{

    public function __construct()
    {
        parent::__construct();
    }

    public function render($name, $id = "")
    {
        return $this->_render("checkbox", $name, $id = "");
    }

}
