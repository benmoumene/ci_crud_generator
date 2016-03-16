<?php

require_once APPPATH . '/libraries/Crud/SelectElement.php';

/**
 * 07-jul-2015
 * File: SelectFkElement.php
 * Encoding: ISO-8859-1
 * Project: ci_crud_generator
 * Description of SelectFkElement
 *
 * @author Diego Olmedo
 */
class SelectFkElement extends SelectElement
{

    public function __construct()
    {
        parent::__construct();
    }

    public function render($name, $id = "")
    {
        $this->_name = $name;
        $this->_id = ! empty($id) ? $id : $name;
        $select_fk = "";
        $select_fk .= $this->_render_query() . PHP_EOL;
        $select_fk .= "<select name='inputs[{$name}]' id='{$id}'>" . PHP_EOL;
        $select_fk .= "<?php " . PHP_EOL;
        $select_fk .= "echo option(0,'Seleccione...',element(\$data, '{$this->_name}', 0));" . PHP_EOL;
        $select_fk .= "foreach(\$rows as \$row) { " . PHP_EOL;
        $select_fk .= "     echo option(\$row['value'],\$row['text'],element(\$data, '{$this->_name}', 0));" . PHP_EOL;
        $select_fk .= "} ?> " . PHP_EOL;
        $select_fk .= "</select>" . PHP_EOL;

        return $select_fk;
    }

    protected function _render_query()
    {
        if (empty($this->_config)) {
            show_error("No están definidas las configuraciones para el elemento select_fk: {$this->_name}");
        }
        //            array(
//            * "table_fk" => La tabla de donde tomar los datos
//            * "value_field" => El campo que se usará para el option.value [default = 'id_{table}']
//            * "text_field" => El campo que se usará para option.text [default = 'nombre']
//            * "where" => Los filtros que se usarán en $this->db->where($where)
//            * "query" => Un query SQL por si es una query más compleja
//            * y no alcanzan con los parámetros anteriores para especificar
//            * los resultados.
//            * )
        $array_to_render = "<?php " . PHP_EOL;
        $array_to_render .= "\$config_{$this->_name} = array(" . PHP_EOL;
        if ( ! empty($this->_config["query"])) {
            $query = str_ireplace("'", '"', $this->_config["query"]);
            $array_to_render .= "'query' => '{$query}'," . PHP_EOL;
        } else {
            $where = str_ireplace("'", '"', $this->_config["where"]);
            $array_to_render .= "'table' => '{$this->_config["table_fk"]}'," . PHP_EOL;
            $array_to_render .= "'value_field' => '{$this->_config["value_field"]}'," . PHP_EOL;
            $array_to_render .= "'text_field' => '{$this->_config["text_field"]}'," . PHP_EOL;
            $array_to_render .= "'where' => '$where'," . PHP_EOL;
        }
        $array_to_render .= ");" . PHP_EOL;
        $array_to_render .= '$rows = options_select_fk($config_' . $this->_name . ');' . PHP_EOL;
        $array_to_render .= "?>" . PHP_EOL;
        return $array_to_render;
    }

}
