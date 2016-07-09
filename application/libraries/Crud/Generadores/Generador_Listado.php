<?php

require_once APPPATH . '/libraries/Crud/Generadores/AbstractGenerador.php';


/**
 * 09-jul-2016
 * File: Generador_listado.php
 * Encoding: ISO-8859-1
 * Project: ci_crud_generator
 * Description of Generador_listado
 *
 * @author Diego Olmedo
 */
class Generador_Listado extends AbstractGenerador
{


    public function generar($ruta_views)
    {
        $nombre_controlador = $this->_oConfigEntidad->nombre_controlador;
        $pisar_listado = $this->_oConfigEntidad->pisar_view_listado_anterior;


        $ruta_listado = "{$ruta_views}/listado_" . $nombre_controlador . ".php";
        $this->_reemplazar_archivo($ruta_listado, $pisar_listado);

        $contenido_listado = file_get_contents(VIEWPATH . "/crud_generator/templates/crud_listado.tpl");
        $cabecera_listado = $this->_generar_cabercera_listado();
        $fila_listado = $this->_get_fila_listado();
        $search = array("{nombre_controlador}", "{cabecera}", "{fila}");
        $replace = array($nombre_controlador, $cabecera_listado, $fila_listado);
        $listado = str_ireplace($search, $replace, $contenido_listado);
        file_put_contents($ruta_listado, $listado);
    }

    private function _generar_cabercera_listado()
    {
        $campos = $this->_oConfigEntidad->campos;
        $nombre_controlador = $this->_oConfigEntidad->nombre_controlador;
        $cabecera = "<tr>" . PHP_EOL;
        $ruta_listado = "/{$nombre_controlador}/listar";
        foreach ($campos as $nombre_campo => $data_campo) {
            $mostrar_listado = element($data_campo, "mostrar_listado", 0) > 0;
            $puede_ordenar = element($data_campo, "puede_ordenar", 0) > 0;
            if ($mostrar_listado) {
                if ($puede_ordenar) {
                    $cabecera .="<th><?php echo link_orden('$ruta_listado', '$nombre_campo', '" . element($data_campo, "label", "") . "'); ?></th>" . PHP_EOL;
                } else {
                    $cabecera .="<th>" . element($data_campo, "label", "") . "</th>" . PHP_EOL;
                }
            }
        }
        $cabecera .= "<th class='text-center'>Acciones</th>" . PHP_EOL;
        $cabecera .= "</tr>" . PHP_EOL;
        return $cabecera;
    }

    private function _get_fila_listado()
    {
        $campos = $this->_oConfigEntidad->campos;
        $nombre_controlador = $this->_oConfigEntidad->nombre_controlador;
        $nombre_pk = $this->_oConfigEntidad->nombre_pk;
        $fila = "<tr>" . PHP_EOL;
        foreach ($campos as $nombre_campo => $data_campo) {
            if (element($data_campo, "mostrar_listado", 0) > 0) {
                $fila .="<td><?php echo element(\$row, '{$nombre_campo}', ''); ?></td>" . PHP_EOL;
            }
        }
        $fila .="<td class='text-center'>"
            . "<div class='btn-group'>"
            . "     <a data-toggle='tooltip' title='editar' class='btn btn-xs btn-default' href='/{$nombre_controlador}/editar/<?php echo element(\$row, '{$nombre_pk}', 0); ?>'><?php echo glyphicon('edit'); ?></a>"
            . "     <a href='javascript:void(0)' data-toggle='tooltip' title='eliminar' class='btn btn-xs btn-danger'><?php echo glyphicon('trash'); ?></a>"
            . "</div>"
            . "</td>" . PHP_EOL;
        $fila .= "</tr>" . PHP_EOL;
        return $fila;
    }

}
