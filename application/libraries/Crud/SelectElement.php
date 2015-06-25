<?php

require_once APPPATH . '/libraries/Crud/AbstractHtmlElement.php';

/**
 * 25/06/2015
 * File: SelectElement.php
 * Encoding: ISO-8859-1
 * Project: ci_crud_generator
 * Description of SelectElement
 *
 * @author Diego Olmedo
 */
class SelectElement
{

    public function __construct()
    {

    }

    public function render($name, $id = "")
    {
        return "<select name='{$name}' id='{$id}'><option value=''>Seleccione...</option></select>";
    }

}
