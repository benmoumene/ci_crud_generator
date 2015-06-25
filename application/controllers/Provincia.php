<?php

require_once APPPATH . "/controllers/Crud/Crud_controller.php";

class Provincia extends Crud_controller
{

    const ENTIDAD = "provincia";
    const RUTA_LISTADO = "/provincia/listar";


    public function __construct()
    {
        parent::__construct();
        $this->load->model("provincia_model");
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
            redirect(self::RUTA_LISTADO . "/id_provincia/desc");
        }
        parent::listar($sOrdenarPor, $sEnSentido);
    }
}