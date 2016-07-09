<?php
require_once APPPATH . "/models/Crud/Crud_model.php";

class {nombre_model} extends Crud_model {

    const TABLA = "{nombre_tabla}";
    const ALIAS = "{alias_tabla}";
    const PK = "{nombre_pk}";

    public function __construct()
    {
        parent::__construct();
    }

    protected function _get_mapper_columnas_orden()
    {
        return array();
    }

    {custom_methods}

}