<?php

$this->load->view("layout/default/header");
if (isset($contenido)) {
    echo $contenido;
}
$this->load->view("layout/default/footer");
?>