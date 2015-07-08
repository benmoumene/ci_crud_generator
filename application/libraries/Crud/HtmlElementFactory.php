<?php

require_once APPPATH . '/libraries/Crud/SelectElement.php';
require_once APPPATH . '/libraries/Crud/SelectFkElement.php';
require_once APPPATH . '/libraries/Crud/TextareaElement.php';
require_once APPPATH . '/libraries/Crud/InputFactory.php';

/**
 * 25/06/2015
 * File: HtmlElementFactory.php
 * Encoding: ISO-8859-1
 * Project: ci_crud_generator
 * Description of HtmlElementFactory
 *
 * @author Diego Olmedo
 */
class HtmlElementFactory
{

    public static function crear_elemento($sTipo)
    {
        $tipo = ucfirst(self::_toCamelCase($sTipo));
        $class = "{$tipo}Element";
        $elementos_no_input = array("select", "textarea", "select_fk");
        try {
            if ( ! in_array($sTipo, $elementos_no_input)) {
                $elemento = InputFactory::crear($tipo);
            } else {
                $elemento = new $class();
            }

            return $elemento;
        } catch (Exception $ex) {
            die("No existe el elemento HTML = {$tipo}");
        }
    }

    private static function _toCamelCase($stringConGuionBajo)
    {
        $partes = explode('_', $stringConGuionBajo);
        $partesUcfirst = array_map('ucfirst', $partes);
        $stringCamelCase = implode('', $partesUcfirst);
        return $stringCamelCase;
    }

}
