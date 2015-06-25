<?php

require_once APPPATH . '/libraries/Crud/InputElement.php';

/**
 * 25/06/2015
 * File: InputHidden.php
 * Encoding: ISO-8859-1
 * Project: ci_crud_generator
 * Description of InputHidden
 *
 * @author Diego Olmedo
 */
class InputHidden extends InputElement
{

    public function __construct()
    {
        parent::__construct();
    }

    public function render($name, $id = "")
    {
        return $this->_render("hidden",$name, $id = "");
    }

}
