<?php

require_once APPPATH . "/controllers/Crud/Crud_controller.php";

class Provincias extends Crud_controller
{

    const ENTIDAD = "provincias";
    const RUTA_LISTADO = "/provincias/listar";

    public function __construct()
    {
        parent::__construct();
        $this->load->model("provincias_model");
    }

    public function index()
    {
        parent::index();
    }

    public function nuevo()
    {
        parent::nuevo();
    }

    public function editar($iId)
    {
        parent::editar($iId);
    }

    public function guardar()
    {

        parent::guardar();
    }

    public function listar($sOrdenarPor = "", $sEnSentido = "")
    {
        if (empty($sOrdenarPor)) {
            redirect(self::RUTA_LISTADO . "/nombre/desc");
        }
        parent::listar($sOrdenarPor, $sEnSentido);
    }

}
