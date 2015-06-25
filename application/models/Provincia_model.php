<?php
require_once APPPATH . "/models/Crud/Crud_model.php";

class Provincia_model extends Crud_model {

    const TABLA = "provincia";
    const PK = "id_provincia";

    public function __construct()
    {
        parent::__construct();
    }
}