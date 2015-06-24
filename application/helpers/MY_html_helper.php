<?php

if ( ! function_exists('link_orden')) {

    /**
     * Arma los <a> para las cabeceras de las tablas con el link para ordenar
     * @param string $sRuta La ruta del listado
     * @param string $sNombreCampo El nombre del campo de ordenamiento
     * @param string $sLabelCampo El label que se muestra en la cabecera
     * @return string El <a> ya armado con la ruta para ordenammiento
     */
    function link_orden($sRuta, $sNombreCampo, $sLabelCampo)
    {
        $orden_actual = strtolower($CI->uri->segment(3));
        $sentido_actual = $CI->uri->segment(4);
        $sentido_contrario = ($sentido_actual === "asc" ? "desc" : "asc");

        $nombre_campo = strtolower($sNombreCampo);
        $descripcion_campo = $sLabelCampo;
        $sentido = ($orden_actual === $nombre_campo) ? $sentido_contrario : "asc";
        $ruta_listado = $sRuta;
        $query_string = "";
        $CI = & get_instance();
        $filtros_busqueda = $CI->input->get();
        $query_string = "";

        if ($filtros_busqueda !== false && count($filtros_busqueda) > 0) :
            $query_string = "?";
            foreach ($filtros_busqueda as $field => $value) :
                $query_string .= $field . "=" . $value . "&";
            endforeach;
            $query_string = trim($query_string, '&');
        endif;

        $class_active = ($order_by === $nombre_campo) ? "class='active'" : "";
        $link = "<a href='{$ruta_listado}/{$nombre_campo}/{$sentido}/$query_string' {$class_active} >{$descripcion_campo}</a>";
        return $link;
    }

}