<?php

require_once APPPATH . "/libraries/Crud/Entities/BE_Config_Entidad.php";

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

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array("url", "crud", "form"));
        $this->load->database();
    }

    public function index()
    {
        redirect("/crud_generator/listar_entidades");
    }

    public function listar_entidades()
    {
        $tablas = $this->db->list_tables();
        $dataLayout = array();
        $dataPagina = array(
            "tablas" => $tablas,
        );
        $dataLayout["contenido"] = $this->load->view("crud_generator/listado_tablas", $dataPagina, TRUE);
        $this->load->view("layout/crud_generator/crud_generator", $dataLayout);
    }

    public function ajax_get_data_entidad()
    {
        $post = $this->input->post();
//        echo "<hr/><pre>";
//        print_r($post);
//        echo "</pre><hr/>";
//        die();
        if ( ! empty($post["entidad"])) {
            $tabla = $post["entidad"];
            $columnas = $this->db->field_data($tabla);
            $tablas = $this->db->list_tables();
            $dataPagina = array(
                "inputs_disponibles" => $this->_get_tipo_inputs(),
                "relacion_input_tipo_columna" => $this->_get_relacion_input_tipo_columna(),
                "columnas" => $columnas,
                "tablas" => $tablas,
            );
            echo json_encode($dataPagina);
            die;
        }
        echo "NO DATA";
    }

    public function generar_entidad()
    {
        $tabla = $this->input->get("tabla");
        if (empty($tabla)) {
            show_error("Falta definir la tabla");
        }
        $columnas = $this->db->field_data($tabla);
        $tablas = $this->db->list_tables();
        $dataLayout = array();
        $dataPagina = array(
            "inputs_disponibles" => $this->_get_tipo_inputs(),
            "relacion_input_tipo_columna" => $this->_get_relacion_input_tipo_columna(),
            "columnas" => $columnas,
            "tablas" => $tablas,
        );
        $dataLayout["contenido"] = $this->load->view("crud_generator/form_generator", $dataPagina, TRUE);
        $this->load->view("layout/crud_generator/crud_generator", $dataLayout);
    }

    public function generar()
    {
        if ($this->input->post("generar") !== FALSE) {
            $alias_tabla = $this->input->post("alias_tabla");
            $oConfigEntidad = new BE_Config_Entidad();
            $oConfigEntidad->nombre_controlador = $this->input->post("entidad");
            $oConfigEntidad->nombre_model = $this->input->post("entidad") . "_model";
            $oConfigEntidad->nombre_tabla = $this->input->post("tabla");
            $oConfigEntidad->alias_tabla = empty($alias_tabla) ? $this->_nombre_tabla : $alias_tabla;
            $oConfigEntidad->nombre_pk = $this->input->post("pk");
            $oConfigEntidad->ordenar_por_default = $this->input->post("ordenar_por");
            $oConfigEntidad->en_sentido_default = $this->input->post("en_sentido");
            $oConfigEntidad->campos = $this->input->post("campos");
            $oConfigEntidad->pisar_view_anterior = $this->input->post("pisar_view_anterior") === "S";
            $oConfigEntidad->pisar_controller_anterior = $this->input->post("pisar_controller_anterior") === "S";
            $oConfigEntidad->pisar_model_anterior = $this->input->post("pisar_model_anterior") === "S";

            $this->_generar_views($oConfigEntidad);
            $this->_generar_controller($oConfigEntidad);
            $this->_generar_model($oConfigEntidad);
        }
    }

    public function ajax_get_columnas_tabla()
    {
        $post = $this->input->post();
        $respuesta = array();
        if ( ! empty($post["tabla"])) {
            $columnas = $this->db->field_data($post["tabla"]);
            $options = array();
            foreach ($columnas as $columna) {
                $option = array(
                    "value" => $columna->name,
                    "text" => $columna->name,
                );
                $options[] = $option;
            }
            $respuesta = $options;
        }
        echo json_encode(array("columnas" => $respuesta));
        die;
    }

    private function _generar_views(BE_Config_Entidad $oConfigEntidad)
    {

        $this->load->library("/Crud/Generadores/Generador_Vista", "generador_vista");
        $this->generador_vista->set_config_entidad($oConfigEntidad);
        $generado = $this->generador_vista->generar($oConfigEntidad);
        echo "Vista Generada <hr/> " . __FILE__ . " -> " . __LINE__ . "<pre>";
        var_dump($generado);
        echo "</pre><hr/>";
    }

    public function test_html($tipo)
    {
        require_once APPPATH . "/libraries/Crud/HtmlElementFactory.php";
        $obj = HtmlElementFactory::crear_elemento($tipo);
        echo "<hr/>" . __FILE__ . " - " . __LINE__ . "<pre>";
        var_dump($obj);
        echo "</pre><hr/>";
        echo $obj->render("foo", "bar");
        die();
    }

    private function _generar_controller(BE_Config_Entidad $oConfigEntidad)
    {
        $this->load->library("/Crud/Generadores/Generador_Controlador", "generador_controlador");
        $this->generador_controlador->set_config_entidad($oConfigEntidad);
        $generado = $this->generador_controlador->generar($oConfigEntidad);
        echo "Controlador Generado <hr/> " . __FILE__ . " -> " . __LINE__ . "<pre>";
        var_dump($generado);
        echo "</pre><hr/>";
    }

    private function _generar_model(BE_Config_Entidad $oConfigEntidad)
    {
        $this->load->library("/Crud/Generadores/Generador_Modelo", "generador_modelo");
        $this->generador_modelo->set_config_entidad($oConfigEntidad);
        $generado = $this->generador_modelo->generar($oConfigEntidad);
        echo "Modelo Generado <hr/> " . __FILE__ . " -> " . __LINE__ . "<pre>";
        var_dump($generado);
        echo "</pre><hr/>";
    }

    /**
     * Devuelve un array de los tipos de inputs disponibles para generar en un form
     * con un formato para poder armar un select.
     * Ej: array('textarea' => '<textarea></textarea>', 'text' => '<input type='text' />')
     * @return string
     */
    private function _get_tipo_inputs()
    {
        $tipos_input = array(
            "textarea" => "textarea",
            "number" => "input type='number'",
            "text" => "input type='text'",
            "email" => "input type='email'",
            "hidden" => "input type='hidden'",
            "checkbox" => "input type='checkbox'",
            "select" => "select",
            "select_fk" => "select FK",
        );
        return $tipos_input;
    }

    /**
     *
     * Devuelve un array de relacion entre el tipo de campo en la db y el tipo de
     * input que tomará por default
     * @return string
     */
    private function _get_relacion_input_tipo_columna()
    {
        //$key => tipo_input
        //$value => field_type que devuelve el mysql
        $relacion_input_tipo_columna = array(
            "text" => "textarea",
            "varchar" => "text",
            "int" => "number",
            "smallint" => "number",
            "char" => "text"
        );
        return $relacion_input_tipo_columna;
    }

}
