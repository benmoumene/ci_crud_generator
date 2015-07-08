<?php

/**
 * 23/06/2015
 * File: AbstractHtmlElement.php
 * Encoding: ISO-8859-1
 * Project: ci_crud_generator
 * Description of AbstractHtmlElement
 *
 * @author Diego Olmedo
 */
abstract class AbstractHtmlElement
{

    protected $_attributes = "";
    protected $_name = "";
    protected $_id = "";
    protected $_config = array();


    public function set_attributes($sAttributes)
    {
        $this->_attributes = (string) $sAttributes;
    }

    public function set_config($aConfig)
    {
        $this->_config = (array) $aConfig;
    }

    abstract public function render($name, $id = "");
}
