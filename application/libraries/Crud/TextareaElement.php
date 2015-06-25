<?php

require_once APPPATH . '/libraries/Crud/AbstractHtmlElement.php';

/**
 * 25/06/2015
 * File: TextareaElement.php
 * Encoding: ISO-8859-1
 * Project: ci_crud_generator
 * Description of TextareaElement
 *
 * @author Diego Olmedo
 */
class TextareaElement
{

    public function __construct()
    {

    }

    public function render($name, $id = "")
    {
        return "<textarea name='{$name}' id='{$id}'><?php echo element(\$data, '{$name}', ''); ?></textarea>";
    }

}
