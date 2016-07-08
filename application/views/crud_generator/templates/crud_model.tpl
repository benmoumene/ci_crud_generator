<?php
require_once APPPATH . "/models/Crud/Crud_model.php";

class {nombre_model} extends Crud_model {

    const TABLA = "{nombre_tabla}";
    const PK = "{nombre_pk}";

    public function __construct()
    {
        parent::__construct();
    }

    protected function _get_mapper_columnas_orden()
    {
        return array();
    }

    protected function _get_query_listado()
    {
        return parent::_get_query_listado();
    }

    protected function _set_columnas_orden()
    {
        return parent::_set_columnas_orden();
    }

    protected function _get_query_count_listado()
    {
        return parent::_get_query_count_listado();
    }

    protected function _set_where()
    {
        return parent::_set_where();
    }

    protected function _eliminar($iValuePK, $bBorradoLogico = TRUE)
    {
        return parent::_eliminar($iValuePK, $bBorradoLogico = TRUE);
    }

}