<?php

require_once APPPATH . '/libraries/AbstractHtmlElement.php';

/**
 * 23/06/2015
 * File: InputElement.php
 * Encoding: ISO-8859-1
 * Project: ci_crud_generator
 * Description of InputElement
 *
 * @author Diego Olmedo
 */
class InputElement extends AbstractHtmlElement
{

    public function __construct()
    {
        parent::__construct();
    }

    public function render()
    {
        $attributes = $this->_attributes;
        return '<input type="" name="" value="" id="" ' . $attributes . '/>';
    }

}
