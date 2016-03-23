<?php

if ( ! function_exists('element')) {

    /**
     * Valida que el elemento buscado exista en el array y devuelve el su valor, o el default en caso
     * de que no exista
     * @param type $aData
     * @param type $sNombre
     * @param type $mDefault
     * @return el  valor del elemento del array o el valor seteado por default o NULL si no fue seteado nada
     */
    function element($aData, $sNombre, $mDefault = NULL)
    {
        if (isset($aData[$sNombre])) {
            return $aData[$sNombre];
        } else if ($mDefault !== NULL) {
            return $mDefault;
        } else {
            return '';
        }
    }

}
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
        $CI = & get_instance();
        $orden_actual = strtolower($CI->uri->segment(3));
        $sentido_actual = $CI->uri->segment(4);
        $sentido_contrario = ($sentido_actual === "asc" ? "desc" : "asc");

        $nombre_campo = strtolower($sNombreCampo);
        $descripcion_campo = $sLabelCampo;
        $sentido = ($orden_actual === $nombre_campo) ? $sentido_contrario : "asc";
        $ruta_listado = $sRuta;
        $query_string = "";
        $filtros_busqueda = $CI->input->get();
        $query_string = "";

        if ($filtros_busqueda !== false && count($filtros_busqueda) > 0) {
            $query_string = "?";
            foreach ($filtros_busqueda as $field => $value) {
                $query_string .= $field . "=" . $value . "&";
            }
            $query_string = trim($query_string, '&');
        }

        $class_active = ($orden_actual === $nombre_campo) ? "class='active'" : "";
        $link = "<a href='{$ruta_listado}/{$nombre_campo}/{$sentido}/$query_string' {$class_active} >{$descripcion_campo}</a>";
        return $link;
    }

}
if ( ! function_exists('glyphicon')) {

    function glyphicon($icon)
    {
        return "<span class='glyphicon glyphicon-{$icon}' aria-hidden='true'></span>";
    }

}

if ( ! function_exists("options_select_fk")) {

    /**
     *
     * @param array $aConfig un array de configuracion del siguiente tipo
     * array(
     *   "table" => La tabla de donde tomar los datos
     *   "value_field" => El campo que se usará para el option.value [default = 'id_{table}']
     *   "text_field" => El campo que se usará para option.text [default = 'nombre']
     *   "where" => Los filtros que se usarán en $this->db->where($where)
     *   "order_by" => El orden del listado Ej: array("campo" => '', "sentido" => '')
     *   "query" => Un query SQL por si es una query más compleja
     *              y no alcanzan con los parámetros anteriores para especificar
     *              los resultados.
     * )
     * @return array Un array de options del tipo array('value' => 12, 'text' => 'Foo')
     */
    function options_select_fk($aConfig)
    {
        $table = element($aConfig, "table");
        $value_field = element($aConfig, "value_field", "id_{$table}");
        $text_field = element($aConfig, "text_field", "nombre");
        $where = element($aConfig, "where", "");
        $query = element($aConfig, "query", "");
        $order_by = element($aConfig, "order_by", "");
        $CI = & get_instance();
        $CI->load->database();
        if ( ! empty($query)) {
            $rds = $CI->db->query($query);
        } else {
            if ( ! empty($order_by)) {
                $CI->db->order_by($order_by["campo"], $order_by["sentido"]);
            }
            $CI->db->select("{$value_field} as value, {$text_field} as text");
            if ( ! empty($where)) {
                $CI->db->where($where);
            }
            $rds = $CI->db->get($table);
        }
        // echo $CI->db->last_query(); die;
        $rows = $rds->result_array();
        return $rows;
    }

}
