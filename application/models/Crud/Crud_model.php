<?php

/**
 * 23/06/2015
 * File: Crud_model.php
 * Encoding: ISO-8859-1
 * Project: ci_crud_generator
 * Description of Crud_model
 *
 * @author Diego Olmedo
 */
class Crud_model extends CI_Model
{

    const TABLA = "no-definida";
    const PK = "no-definido";
    const ORDENAR_POR_SEGMENT = 3;
    const EN_SENTIDO_SEGMENT = 4;
    const PAGE_SEGMENT = 5;
    const RPP = 15;

    protected $_tabla;
    protected $_pk;
    protected $_rpp;
    protected $_page_segment;
    protected $_ordenar_por;
    protected $_en_sentido;
    protected $_tiene_eliminado_logico = FALSE;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->_tabla = static::TABLA;
        $this->_pk = static::PK;
        $this->_ordenar_por = $this->_pk;
        $this->_en_sentido = "DESC";
        $this->_rpp = static::RPP;
    }

    public function set_tiene_eliminado_logico($bTieneEliminadoLogico = NULL)
    {
        if ($bTieneEliminadoLogico === NULL) {
            $bTieneEliminadoLogico = $this->db->field_exists('eliminado', static::TABLA);
        }
        $this->_tiene_eliminado_logico = (bool) $bTieneEliminadoLogico;
    }

    public function eliminar_fisico($iValuePK)
    {
        return $this->_eliminar($iValuePK, FALSE);
    }

    public function eliminar_logico($iValuePK)
    {
        return $this->_eliminar($iValuePK);
    }

    public function actualizar($iValuePK, $aValues)
    {
        $value_pk = (int) $iValuePK;
        $values = (array) $aValues;
        $where = array(static::PK => $value_pk);
        $this->db->update(static::TABLA, $values, $where);
        $affected_rows = $this->db->affected_rows();
        return $affected_rows;
    }

    public function insertar($aValues)
    {
        $values = (array) $aValues;
        $this->db->insert(static::TABLA, $values);
        $id_insertado = $this->db->insert_id();
        return $id_insertado;
    }

    /**
     * Alias de get_by_pk
     * @param int $iValue
     */
    public function get_por_id($iValue)
    {
        return $this->get_by_pk($iValue);
    }

    public function get_by_pk($iValue)
    {
        $value = (int) $iValue;
        $where = array(static::PK => $value);
        $query = $this->db->get_where(static::TABLA, $where);
        $row = $query->row_array();
        return $row;
    }

    public function count_all()
    {
        $custom_count = $this->_get_query_count_listado();
        if ( ! empty($custom_count)) {
            return $custom_count;
        }
        if ($this->_tiene_eliminado_logico === TRUE) {
            $this->db->where(array("eliminado" => 0));
        }
        $this->_set_where();
        return $this->db->count_all_results(static::TABLA);
    }

    public function get_all()
    {

        $this->_set_where();
        $query = $this->_get_query_listado();
        $result = $query->result_array();
        //echo $this->db->last_query();die;
        return $result;
    }

    public function get_campo_pk()
    {
        return static::PK;
    }

    public function get_rpp()
    {
        return static::RPP;
    }

    public function get_page_segment()
    {
        return static::PAGE_SEGMENT;
    }

//<editor-fold defaultstate="collapsed" desc="Protected Functions">
    protected function _get_mapper_columnas_orden()
    {
        return array();
    }


    protected function _get_query_listado()
    {
        $this->_set_columnas_orden();
        $pagina = $this->uri->segment(static::PAGE_SEGMENT);
        $offset = (($pagina > 0 ? $pagina : 1 ) * $this->_rpp) - $this->_rpp;
        if ( ! empty($this->_ordenar_por)) {
            $this->db->order_by($this->_ordenar_por, $this->_en_sentido);
        }
        $this->db->limit($this->_rpp, $offset);
        $query = $this->db->get(static::TABLA);
        return $query;
    }

    protected function _set_columnas_orden()
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
    }

    protected function _get_query_count_listado()
    {

    }

    protected function _set_where()
    {
        if ($this->_tiene_eliminado_logico === TRUE) {
            $this->db->where(array("eliminado" => 0));
        }
    }

    protected function _eliminar($iValuePK, $bBorradoLogico = TRUE)
    {
        $value_pk = (int) $iValuePK;
        $where = array(static::PK => $value_pk);
        if ($bBorradoLogico !== FALSE) {
            $values = array("eliminado" => 1);
            $this->db->update(static::TABLA, $values, $where);
        } else {
            $this->db->delete(static::TABLA, $where);
        }
        return $this->db->affected_rows();
    }

//</editor-fold>
}
