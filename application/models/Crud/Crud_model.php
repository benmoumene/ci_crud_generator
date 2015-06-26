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
        return $this->db->count_all(static::TABLA);
    }

    public function get_all()
    {
        $param_ordenar_por = $this->uri->segment(static::ORDENAR_POR_SEGMENT);
        if ( ! empty($param_ordenar_por)) {
            $this->_ordenar_por = $param_ordenar_por;
        }
        $param_en_sentido = $this->uri->segment(static::EN_SENTIDO_SEGMENT);
        if ( ! empty($param_en_sentido)) {
            $this->_en_sentido = strtoupper($param_en_sentido);
        }
        $pagina = $this->uri->segment(static::PAGE_SEGMENT);
        $offset = (($pagina > 0 ? $pagina : 1 ) * $this->_rpp) - $this->_rpp;
        $this->db->order_by($this->_ordenar_por, $this->_en_sentido);
        $this->db->limit($this->_rpp, $offset);
        $query = $this->db->get(static::TABLA);
        $result = $query->result_array();
        return $result;
    }

    public function get_campo_pk()
    {
        return static::PK;
    }

}
