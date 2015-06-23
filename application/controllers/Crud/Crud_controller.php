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
class Crud_controller extends CI_Controller
{

    const ENTIDAD = "";
    const RUTA_LISTADO = "/";

    protected $_entidad;

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array("url", "form"));
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
        $rows = $this->modelo_entidad->get_all();
        $total_rows = $this->modelo_entidad->count_all();
        $segmento_ordenar_por = ( ! empty($param_ordenar_por)) ? "/{$param_ordenar_por}" : "no-definido";
        $segmento_en_sentido = ( ! empty($param_en_sentido)) ? "/{$param_en_sentido}" : "no-definido";
        $ruta_paginacion = static::RUTA_LISTADO . "{$segmento_ordenar_por}{$segmento_en_sentido}/";
        init_pagination($ruta_paginacion, $total_rows, Crud_model::RPP, Crud_model::PAGE_SEGMENT);

        $dataPagina = array();
        $dataPagina["registros"] = $rows;
        $dataPagina["paginador"] = $this->pagination->create_links();
        $this->load->view($this->_entidad . "/listado_{$this->_entidad}", $dataPagina);
    }

    public function nuevo()
    {
        $this->load->view($this->_entidad . "/form_{$this->_entidad}");
    }

    public function editar($iId)
    {
        $id = (int) $iId;
        $this->load->view($this->_entidad . "/form_{$this->_entidad}");
    }

    public function guardar()
    {

    }

}
