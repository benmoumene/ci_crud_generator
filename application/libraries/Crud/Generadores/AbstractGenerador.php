<?php

/**
 * 09-jul-2016
 * File: AbstractGenerador.php
 * Encoding: ISO-8859-1
 * Project: ci_crud_generator
 * Description of AbstractGenerador
 *
 * @author Diego Olmedo
 */
class AbstractGenerador
{

    protected $_oConfigEntidad;

    protected function _reemplazar_archivo($ruta_archivo, $pisar)
    {
        if (is_file($ruta_archivo)) {
            if ($pisar) {
                unlink($ruta_archivo);
            } else {
                rename($ruta_archivo, "{$ruta_archivo}.old_" . date("Ymd_his"));
            }
        }
    }

    public function set_config_entidad(BE_Config_Entidad $oConfigEntidad)
    {
        $this->_oConfigEntidad = $oConfigEntidad;
    }

}
