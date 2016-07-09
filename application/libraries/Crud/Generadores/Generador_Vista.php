<?php

require_once APPPATH . '/libraries/Crud/Generadores/AbstractGenerador.php';

/**
 * 09-jul-2016
 * File: Generador_Vista.php
 * Encoding: ISO-8859-1
 * Project: ci_crud_generator
 * Description of Generador_Vista
 *
 * @author Diego Olmedo
 */
class Generador_Vista extends AbstractGenerador
{

    private $_CI;

    protected $_ruta_views;
    public function __construct()
    {
        $this->_CI = & get_instance();
    }

    public function generar()
    {
        $nombre_controlador = $this->_oConfigEntidad->nombre_controlador;
        $this->_ruta_views = VIEWPATH . "/" . $nombre_controlador;
        if ( ! is_dir($this->_ruta_views)) {
            mkdir($this->_ruta_views, 0777, TRUE);
        }

        try {
            //Genero listado
            $this->_CI->load->library("/Crud/Generadores/Generador_Listado", "generador_listado");
            $this->_CI->generador_listado->set_config_entidad($this->_oConfigEntidad);
            $this->_CI->generador_listado->generar($this->_ruta_views);
            //Genero form
            $this->_CI->load->library("/Crud/Generadores/Generador_Form", "generador_form");
            $this->_CI->generador_form->set_config_entidad($this->_oConfigEntidad);
            $this->_CI->generador_form->generar($this->_ruta_views);
            return TRUE;
        } catch (Exception $ex) {
            return FALSE;
        }
    }

}
