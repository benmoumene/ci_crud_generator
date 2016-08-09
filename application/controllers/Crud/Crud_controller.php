<?php

/**
 * 23/06/2015
 * File: Crud_controller.php
 * Encoding: ISO-8859-1
 * Project: ci_crud_generator
 * Description of Crud_controller
 *
 * @author Diego Olmedo
 */
abstract class Crud_controller extends CI_Controller
{

    const ENTIDAD = "";
    const RUTA_LISTADO = "/";

    protected $_entidad;
    protected $_dataPagina = array();
    protected $_dataLayout = array();

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array("url", "form", "crud"));
        $this->_entidad = static::ENTIDAD;
        $this->load->model(array("Crud/Crud_model", "{$this->_entidad}_model" => "modelo_entidad"));
    }

    public function index()
    {
        redirect(static::RUTA_LISTADO);
    }

    public function listar($sOrdenarPor = "", $sEnSentido = "")
    {
        $this->load->helper("paginador");
        $this->load->library(array("pagination"));
        $param_ordenar_por = (string) $sOrdenarPor;
        $param_en_sentido = ! empty($sEnSentido) ? (strtoupper($sEnSentido) === "DESC" ? "desc" : "asc") : "";
        $rows = $this->_get_rows();
        $total_rows = $this->_count_all();
        $segmento_ordenar_por = ( ! empty($param_ordenar_por)) ? "/{$param_ordenar_por}" : "no-definido";
        $segmento_en_sentido = ( ! empty($param_en_sentido)) ? "/{$param_en_sentido}" : "no-definido";
        $ruta_paginacion = static::RUTA_LISTADO . "{$segmento_ordenar_por}{$segmento_en_sentido}/";
        init_pagination($ruta_paginacion, $total_rows, $this->modelo_entidad->get_rpp(), $this->modelo_entidad->get_page_segment());


        $this->_dataPagina["rows"] = $rows;
        $this->_dataPagina["cant_registros"] = $total_rows;
        $this->_dataPagina["RPP"] = $this->modelo_entidad->get_rpp();
        $this->_dataPagina["paginador"] = $this->pagination->create_links();
        $this->_dataLayout["contenido"] = $this->load->view($this->_entidad . "/listado_{$this->_entidad}", $this->_dataPagina, TRUE);
        $this->load->view("layout/default/default", $this->_dataLayout);
    }

    protected function _get_rows()
    {
        $rows = $this->modelo_entidad->get_all();
        return $rows;
    }

    protected function _count_all()
    {
        return $this->modelo_entidad->count_all();
    }

    public function nuevo()
    {
        $this->_dataPagina["data"] = array();
        $this->_dataLayout["contenido"] = $this->load->view($this->_entidad . "/form_{$this->_entidad}", $this->_dataPagina, TRUE);
        $this->load->view("layout/default/default", $this->_dataLayout);
    }

    public function editar($iId)
    {
        $id = (int) $iId;
        if (empty($id)) {
            show_error("Debe especificar un identificador", 501);
        }
        $this->_dataPagina["data"] = array_merge($this->modelo_entidad->get_by_pk($id), $this->_dataPagina["data"]);
        $this->_dataLayout["contenido"] = $this->load->view($this->_entidad . "/form_{$this->_entidad}", $this->_dataPagina, TRUE);
        $this->load->view("layout/default/default", $this->_dataLayout);
    }

    public function guardar()
    {
        if ($this->input->post("guardar") !== FALSE) {
            $inputs = $this->input->post("inputs");
            $values = (array) $inputs;
            $value_pk = 0;
            $campo_pk = $this->modelo_entidad->get_campo_pk();
            if (isset($values[$campo_pk]) AND (int) $values[$campo_pk] > 0) {
                $value_pk = (int) $values[$campo_pk];
                $id_editando = $value_pk;
            }
            unset($values[$campo_pk]);
            if ($value_pk > 0) {
                $affected_rows = $this->modelo_entidad->actualizar($value_pk, $values);
                if ( ! $affected_rows OR $affected_rows < 0) {
                    show_error("Error al actualizar guardar el registro");
                }
            } else {
                $id_insertado = $this->modelo_entidad->insertar($values);
                if ($id_insertado <= 0) {
                    show_error("Error al intentar guardar el registro");
                }
                $id_editando = $id_insertado;
            }
            redirect("/" . static::ENTIDAD . "/editar/{$id_editando}");
        }
    }

}
