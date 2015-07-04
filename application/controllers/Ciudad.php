<?php

require_once APPPATH . "/controllers/Crud/Crud_controller.php";

class Ciudad extends Crud_controller
{

    const ENTIDAD = "ciudad";
    const RUTA_LISTADO = "/ciudad/listar";


    public function __construct()
    {
        parent::__construct();
        $this->load->model("ciudad_model");
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
            redirect(self::RUTA_LISTADO . "/id_ciudad/desc");
        }
        parent::listar($sOrdenarPor, $sEnSentido);
    }
}