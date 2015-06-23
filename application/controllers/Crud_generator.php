<?php

/**
 * 23/06/2015
 * File: Crud_generator.php
 * Encoding: ISO-8859-1
 * Project: ci_crud_generator
 * Description of Crud_generator
 *
 * @author Diego Olmedo
 */
class Crud_generator extends CI_Controller
{

    private $_nombre_controlador;
    private $_nombre_model;
    private $_nombre_tabla;
    private $_nombre_pk;

    public function index()
    {
        $this->load->view("crud_generator/form_generator");
    }

    public function generar()
    {
        if ($this->input->post("generar") !== FALSE) {
            $this->_nombre_controlador = $this->input->post("entidad");
            $this->_nombre_model = $this->input->post("entidad") . "_model";
            $this->_nombre_tabla = $this->input->post("tabla");
            $this->_nombre_pk = $this->input->post("pk");
            $this->_ordenar_por_default = $this->input->post("ordenar_por");
            $this->_en_sentido_default = $this->input->post("en_sentido");

            $this->_generar_views();
            $this->_generar_controller();
            $this->_generar_model();
        }
    }

    private function _generar_views()
    {
        $ruta_views = VIEWPATH . "/" . $this->_nombre_controlador;
        if ( ! is_dir($ruta_views)) {
            mkdir($ruta_views, 0777, TRUE);
        }
        $ruta_listado = "{$ruta_views}/listado_" . $this->_nombre_controlador . ".php";
        if (is_file($ruta_listado)) {
            unlink($ruta_listado);
        }
        $contenido_listado = file_get_contents(VIEWPATH . "/crud_generator/templates/crud_listado.tpl");
        file_put_contents($ruta_listado, $contenido_listado);

        $ruta_form = "{$ruta_views}/form_" . $this->_nombre_controlador . ".php";
        if (is_file($ruta_form)) {
            unlink($ruta_form);
        }
        $contenido_form = file_get_contents(VIEWPATH . "/crud_generator/templates/crud_form.tpl");
        file_put_contents($ruta_form, $contenido_form);
    }

    private function _generar_controller()
    {
        $tpl = file_get_contents(VIEWPATH . "/crud_generator/templates/crud_controller.tpl");
        $search = array("{nombre_controlador}", "{nombre_entidad}", "{ordenar_por_default}", "{en_sentido_default}");
        $replace = array(ucfirst($this->_nombre_controlador), $this->_nombre_controlador, $this->_ordenar_por_default, $this->_en_sentido_default);
        $contenido = str_ireplace($search, $replace, $tpl);
        $ruta_controller = APPPATH . "/controllers/" . ucfirst($this->_nombre_controlador) . ".php";
        if (is_file($ruta_controller)) {
            //acá habría que hacer un rename
            unlink($ruta_controller);
        }
        file_put_contents($ruta_controller, $contenido);
    }

    private function _generar_model()
    {
        $tpl = file_get_contents(VIEWPATH . "/crud_generator/templates/crud_model.tpl");
        $search = array("{nombre_model}", "{nombre_tabla}", "{nombre_pk}");
        $replace = array(ucfirst($this->_nombre_model), $this->_nombre_tabla, $this->_nombre_pk);
        $contenido = str_ireplace($search, $replace, $tpl);
        $ruta_model = APPPATH . "/models/" . ucfirst($this->_nombre_model) . ".php";
        if (is_file($ruta_model)) {
            //acá habría que hacer un rename
            unlink($ruta_model);
        }
        file_put_contents($ruta_model, $contenido);
    }

}
