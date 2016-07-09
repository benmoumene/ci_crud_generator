<?php

require_once APPPATH . '/libraries/Crud/Generadores/AbstractGenerador.php';

/**
 * 09-jul-2016
 * File: GeneradorModelos.php
 * Encoding: ISO-8859-1
 * Project: ci_crud_generator
 * Description of GeneradorModelos
 *
 * @author Diego Olmedo
 */
class Generador_Modelo extends AbstractGenerador
{

    private $_CI;

    public function __construct()
    {
        $this->_CI = & get_instance();
    }


    public function generar()
    {
        $nombre_model = ucfirst($this->_oConfigEntidad->nombre_model);
        $nombre_tabla = $this->_oConfigEntidad->nombre_tabla;
        $nombre_pk = $this->_oConfigEntidad->nombre_pk;
        $pisar_model = $this->_oConfigEntidad->pisar_model_anterior;
        $tpl = file_get_contents(VIEWPATH . "/crud_generator/templates/crud_model.tpl");
        $search = array("{nombre_model}", "{nombre_tabla}", "{nombre_pk}");
        $replace = array($nombre_model, $nombre_tabla, $nombre_pk);
        $contenido = str_ireplace($search, $replace, $tpl);
        $ruta_model = APPPATH . "/models/" . ucfirst($nombre_model) . ".php";
        $this->_reemplazar_archivo($ruta_model, $pisar_model);
        try {
            file_put_contents($ruta_model, $contenido);
            return TRUE;
        } catch (Exception $ex) {
            return FALSE;
        }
    }

}
