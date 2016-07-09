<?php

require_once APPPATH . '/libraries/Crud/Generadores/AbstractGenerador.php';

/**
 * 09-jul-2016
 * File: Generador_Controlador.php
 * Encoding: ISO-8859-1
 * Project: ci_crud_generator
 * Description of Generador_Controlador
 *
 * @author Diego Olmedo
 */
class Generador_Controlador extends AbstractGenerador
{

    private $_CI;

    public function __construct()
    {
        $this->_CI = & get_instance();
    }

    public function generar()
    {
        $nombre_controlador = $this->_oConfigEntidad->nombre_controlador;
        $ordenar_por_default = $this->_oConfigEntidad->ordenar_por_default;
        $en_sentido_default = $this->_oConfigEntidad->en_sentido_default;
        $pisar_controller = $this->_oConfigEntidad->pisar_controller_anterior;

        if(empty($nombre_controlador)){
            show_error("Falta definir el nombre del controlador");
        }
        $tpl = file_get_contents(VIEWPATH . "/crud_generator/templates/crud_controller.tpl");
        $search = array("{nombre_controlador}", "{nombre_entidad}", "{ordenar_por_default}", "{en_sentido_default}");
        $replace = array(ucfirst($nombre_controlador), $nombre_controlador, $ordenar_por_default, $en_sentido_default);
        $contenido = str_ireplace($search, $replace, $tpl);
        $ruta_controller = APPPATH . "/controllers/" . ucfirst($nombre_controlador) . "_new.php";
        $this->_reemplazar_archivo($ruta_controller, $pisar_controller);
        try {
            file_put_contents($ruta_controller, $contenido);
            return TRUE;
        } catch (Exception $ex) {
            return FALSE;
        }
    }

}
