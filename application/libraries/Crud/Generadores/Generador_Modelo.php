<?php

require_once APPPATH . '/libraries/Crud/Generadores/AbstractGenerador.php';

/**
 * 09-jul-2016
 * File: GeneradorModelos.php
 * Encoding: ISO-8859-1
 * Project: ci_crud_generator
 * Description of GeneradorModelos
 *
 * @author Diego Olmedo
 */
class Generador_Modelo extends AbstractGenerador
{

    private $_CI;

    public function __construct()
    {
        $this->_CI = & get_instance();
    }

    public function generar()
    {
        $nombre_model = ucfirst($this->_oConfigEntidad->nombre_model);
        $nombre_tabla = $this->_oConfigEntidad->nombre_tabla;
        $alias_tabla = $this->_oConfigEntidad->alias_tabla;
        $nombre_pk = $this->_oConfigEntidad->nombre_pk;
        $pisar_model = $this->_oConfigEntidad->pisar_model_anterior;
        $custom_methods = "";
        $custom_methods .= $this->_generar_custom_select() . PHP_EOL;
        $custom_methods .= $this->_generar_custom_joins() . PHP_EOL;
        $custom_methods .= $this->_generar_custom_where() . PHP_EOL;
        $tpl = file_get_contents(VIEWPATH . "/crud_generator/templates/crud_model.tpl");
        $search = array("{nombre_model}", "{nombre_tabla}", "{alias_tabla}", "{nombre_pk}", "{custom_methods}");
        $replace = array($nombre_model, $nombre_tabla, $alias_tabla, $nombre_pk, $custom_methods);
        $contenido = str_ireplace($search, $replace, $tpl);
        $ruta_model = APPPATH . "/models/" . ucfirst($nombre_model) . ".php";
        $this->_reemplazar_archivo($ruta_model, $pisar_model);
        try {
            file_put_contents($ruta_model, $contenido);
            return TRUE;
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    protected function _generar_custom_joins()
    {
        $joins = "";
        foreach ($this->_oConfigEntidad->campos as $campo_listado) {
            if ( ! empty($campo_listado["join"]["tabla"]) AND $campo_listado["join"]["tabla"] <> "N/A") {
                $joins .= $this->_armar_sentencia_join($campo_listado["join"]);
            }
        }
        $custom_join_method = <<<CUSTOM
    protected function _set_joins_sentencia()
    {
        {$joins}
    }
CUSTOM;
        return $custom_join_method;
    }

    protected function _generar_custom_select()
    {
        $columnas = array();
        $select_string = '$this->db->select("';
        foreach ($this->_oConfigEntidad->campos as $campo_listado) {
            if ((int) element($campo_listado, "mostrar_listado", 0) === 1) {
                $columnas[] = $campo_listado["columna"];
            }
        }
        $select_string.= implode(", ", $columnas);
        $select_string.='", FALSE);';

        $custom_select_method = <<<CUSTOM
    protected function _set_select_sentencia()
    {
        {$select_string}
    }
CUSTOM;

        return $custom_select_method;
    }

    protected function _generar_custom_where()
    {
        $custom_where_method = "";
        if ( ! empty($this->_oConfigEntidad->listado_custom_where)) {
            $where_string = '$this->db->where("';
            $where_string .=$this->_oConfigEntidad->listado_custom_where;
            $where_string .='");';
            $custom_where_method = <<<CUSTOM
    protected function _set_where_sentencia()
    {
        {$where_string}
    }
CUSTOM;
        }
        return $custom_where_method;
    }

    protected function _armar_sentencia_join($aDataJoin)
    {
        $nombre_tbl_entidad = $this->_oConfigEntidad->nombre_tabla;
        $alias_tbl_entidad = $this->_oConfigEntidad->alias_tabla;
        $nombre_tbl_join = $aDataJoin["tabla"];
        $alias_tbl_join = $aDataJoin["alias_tabla"];
        $on = $aDataJoin["on"];
        $tipo_join = $aDataJoin["tipo_join"];
        $join = '$this->db->join(';
        $join .= '"' . $nombre_tbl_join . ' AS ' . $alias_tbl_join . '",';
        $join .= '"' . $on . '",';
        $join .= '"' . $tipo_join . '"';
        $join .= ');' . PHP_EOL;
        return $join;
    }

    /*
      public function get_all()
      {
      $mapper_columnas_orden = $this->_get_mapper_columnas_orden();
      $param_ordenar_por = $this->uri->segment(static::ORDENAR_POR_SEGMENT);
      if ( ! empty($param_ordenar_por)) {
      if ( ! empty($mapper_columnas_orden)) {
      if (isset($mapper_columnas_orden[$param_ordenar_por])) {
      $this->_ordenar_por = $param_ordenar_por;
      }
      } else { //si no está seteado el mapper, lo mando directo
      $this->_ordenar_por = $param_ordenar_por;
      }
      }
      $param_en_sentido = $this->uri->segment(static::EN_SENTIDO_SEGMENT);
      if ( ! empty($param_en_sentido)) {
      $sentido = strtoupper($param_en_sentido) === "DESC" ? "DESC" : "ASC";
      $this->_en_sentido = strtoupper($sentido);
      }
      $pagina = $this->uri->segment(static::PAGE_SEGMENT);
      $offset = (($pagina > 0 ? $pagina : 1 ) * $this->_rpp) - $this->_rpp;
      if ( ! empty($this->_ordenar_por)) {
      $this->db->order_by($this->_ordenar_por, $this->_en_sentido);
      }
      $this->db->limit($this->_rpp, $offset);
      $query = $this->db->get(static::TABLA);
      return $query;
      }
     */

    protected function _generar_custom_count_all()
    {

    }

}
