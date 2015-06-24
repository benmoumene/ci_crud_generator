<?php

/**
 * 23/06/2015
 * File: Crud_generator.php
 * Encoding: ISO-8859-1
 * Project: ci_crud_generator
 * Description of Crud_generator
 *
 * @author Diego Olmedo
 */
class Crud_generator extends CI_Controller
{

    private $_nombre_controlador;
    private $_nombre_model;
    private $_nombre_tabla;
    private $_nombre_pk;

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array("url", "form"));
        $this->load->database();
    }

    public function index()
    {
        $tabla = $this->input->get("tabla");

        if (empty($tabla)) {
            show_error("Falta definir la tabla");
        }
        $columnas = $this->db->field_data($tabla);

        $dataLayout = array();
        $dataPagina = array("columnas" => $columnas);
        $dataLayout["contenido"] = $this->load->view("crud_generator/form_generator", $dataPagina, TRUE);
        $this->load->view("layout/crud_generator/crud_generator", $dataLayout);
    }

    public function generar()
    {
        echo "<hr/>" . __FILE__ . " - " . __LINE__ . "<pre>";
        print_r($this->input->post());
        echo "</pre><hr/>";


        /**
          Array
          (
          [entidad] => ciudad
          [tabla] => ciudad
          [en_sentido] => desc
          [campos] => Array
          (
          [id_ciudad] => Array
          (
          [tipo_campo] => number
          )

          [id_provincia] => Array
          (
          [tipo_campo] => number
          )

          [nombre] => Array
          (
          [tipo_campo] => text
          )

          [cod_postal] => Array
          (
          [tipo_campo] => text
          )

          [activo] => Array
          (
          [tipo_campo] => select
          )

          )

          [pk] => id_ciudad
          [ordenar_por] => id_ciudad
          [generar] => Generar
          )
         */
        if ($this->input->post("generar") !== FALSE) {
            $this->_nombre_controlador = $this->input->post("entidad");
            $this->_nombre_model = $this->input->post("entidad") . "_model";
            $this->_nombre_tabla = $this->input->post("tabla");
            $this->_nombre_pk = $this->input->post("pk");
            $this->_ordenar_por_default = $this->input->post("ordenar_por");
            $this->_en_sentido_default = $this->input->post("en_sentido");

            $this->_generar_views($this->input->post("campos"));
            $this->_generar_controller();
            $this->_generar_model();
        }
    }

    private function _generar_views($campos)
    {
        $ruta_views = VIEWPATH . "/" . $this->_nombre_controlador;
        if ( ! is_dir($ruta_views)) {
            mkdir($ruta_views, 0777, TRUE);
        }
        $ruta_listado = "{$ruta_views}/listado_" . $this->_nombre_controlador . ".php";
        if (is_file($ruta_listado)) {
            unlink($ruta_listado);
        }
        $contenido_listado = file_get_contents(VIEWPATH . "/crud_generator/templates/crud_listado.tpl");
        $cabecera_listado = $this->_generar_cabercera_listado($campos);
        $fila_listado = $this->_get_fila_listado($campos);
        $search = array("{cabecera}", "{fila}");
        $replace = array($cabecera_listado, $fila_listado);
        $listado = str_ireplace($search, $replace, $contenido_listado);
        file_put_contents($ruta_listado, $listado);

        $ruta_form = "{$ruta_views}/form_" . $this->_nombre_controlador . ".php";
        if (is_file($ruta_form)) {
            unlink($ruta_form);
        }
        $contenido_form = file_get_contents(VIEWPATH . "/crud_generator/templates/crud_form.tpl");
        $inputs_form = $this->_generar_inputs_form($campos);
        //echo $inputs_form;
        $search = array("{nombre_controlador}", "{inputs_form}");
        $replace = array($this->_nombre_controlador, $inputs_form);
        $form = str_ireplace($search, $replace, $contenido_form);
        file_put_contents($ruta_form, $form);
    }

    private function _generar_cabercera_listado($campos)
    {

        $cabecera = "<tr>";
        foreach ($campos as $nombre_campo => $data_campo) {
            if (isset($data_campo["mostrar_listado"]) AND (int) $data_campo["mostrar_listado"] === 1) {
                $cabecera .="<th>{$nombre_campo}</th>";
            }
        }
        $cabecera .= "</tr>";
        return $cabecera;
    }

    private function _get_fila_listado($campos)
    {
        $fila = "<tr>";
        foreach ($campos as $nombre_campo => $data_campo) {
            if (isset($data_campo["mostrar_listado"]) AND (int) $data_campo["mostrar_listado"] === 1) {
                $fila .="<td><?php echo get_value(\$row, '{$nombre_campo}', ''); ?></td>";
            }
        }
        $fila .= "</tr>";
        return $fila;
    }

    private function _generar_inputs_form($campos)
    {
        $html = "";
        foreach ($campos as $nombre_campo => $data_campo) {

            if (isset($data_campo["generar_input"]) AND (int) $data_campo["generar_input"] === 1) {
                $tipo_campo = $data_campo["tipo_campo"];
                $html.="<div>" . PHP_EOL;
                if ($tipo_campo !== "hidden") {
                    $html.="<label>{$nombre_campo}:</label><br/>" . PHP_EOL;
                }

                if ($tipo_campo === "hidden") {
                    $html.="<input type='hidden' name='inputs[{$nombre_campo}]' value='<?php echo get_value(\$data,'{$nombre_campo}',0); ?>' />" . PHP_EOL;
                }
                if ($tipo_campo === "text") {
                    $html.="<input type='text' name='inputs[{$nombre_campo}]' value='<?php echo get_value(\$data,'{$nombre_campo}',''); ?>' />" . PHP_EOL;
                }
                if ($tipo_campo === "email") {
                    $html.="<input type='email' name='inputs[{$nombre_campo}]' value='<?php echo get_value(\$data,'{$nombre_campo}',''); ?>' />" . PHP_EOL;
                }
                if ($tipo_campo === "number") {
                    $html.="<input type='number' name='inputs[{$nombre_campo}]' value='<?php echo get_value(\$data,'{$nombre_campo}',''); ?>' />" . PHP_EOL;
                }
                if ($tipo_campo === "checkbox") {
                    $html.="<input type='checkbox' name='inputs[{$nombre_campo}]' value='1' />" . PHP_EOL;
                }
                if ($tipo_campo === "select") {
                    $html.="<select name='inputs[{$nombre_campo}]' ><option value=''>Seleccione...</option></select>" . PHP_EOL;
                }
                if ($tipo_campo === "textarea") {
                    $html.="<textarea name='inputs[{$nombre_campo}]' value='<?php echo get_value(\$data,'{$nombre_campo}',''); ?>' ></textarea>" . PHP_EOL;
                }
                $html .="</div>" . PHP_EOL;
            }
        }
        return $html;
    }

    private function _generar_controller()
    {
        $tpl = file_get_contents(VIEWPATH . "/crud_generator/templates/crud_controller.tpl");
        $search = array("{nombre_controlador}", "{nombre_entidad}", "{ordenar_por_default}", "{en_sentido_default}");
        $replace = array(ucfirst($this->_nombre_controlador), $this->_nombre_controlador, $this->_ordenar_por_default, $this->_en_sentido_default);
        $contenido = str_ireplace($search, $replace, $tpl);
        $ruta_controller = APPPATH . "/controllers/" . ucfirst($this->_nombre_controlador) . ".php";
        if (is_file($ruta_controller)) {
            //acá habría que hacer un rename
            unlink($ruta_controller);
        }
        file_put_contents($ruta_controller, $contenido);
    }

    private function _generar_model()
    {
        $tpl = file_get_contents(VIEWPATH . "/crud_generator/templates/crud_model.tpl");
        $search = array("{nombre_model}", "{nombre_tabla}", "{nombre_pk}");
        $replace = array(ucfirst($this->_nombre_model), $this->_nombre_tabla, $this->_nombre_pk);
        $contenido = str_ireplace($search, $replace, $tpl);
        $ruta_model = APPPATH . "/models/" . ucfirst($this->_nombre_model) . ".php";
        if (is_file($ruta_model)) {
            //acá habría que hacer un rename
            unlink($ruta_model);
        }
        file_put_contents($ruta_model, $contenido);
    }

}
