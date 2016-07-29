<?php

require_once APPPATH . '/libraries/Crud/AbstractHtmlElement.php';

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

    }

    public function render($name, $id = "")
    {

    }

    protected function _render($type, $name, $id = "")
    {
        $id = !empty($id) ? $id : $name;
        return "<input type='{$type}' class='form-control' name='inputs[{$name}]' value='<?php echo element(\$data,'{$name}',''); ?>' id='{$id}' {$this->_attributes} />";
    }

}
