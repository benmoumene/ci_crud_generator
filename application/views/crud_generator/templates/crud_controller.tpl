<?php

require_once APPPATH . "/controllers/Crud/Crud_controller.php";

class {nombre_controlador} extends Crud_controller
{

    const ENTIDAD = "{nombre_entidad}";
    const RUTA_LISTADO = "/{nombre_entidad}/listar";


    public function __construct()
    {
        parent::__construct();
        $this->load->model("{nombre_entidad}_model");
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
            redirect(self::RUTA_LISTADO . "/{ordenar_por_default}/{en_sentido_default}");
        }
        parent::listar($sOrdenarPor, $sEnSentido);
    }
}