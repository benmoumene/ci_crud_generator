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
    private $_campos;
    private $_pisar_anterior;

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array("url", "crud", "form"));
        $this->load->database();
    }

    public function index()
    {
        redirect("/crud_generator/listar_entidades");
    }

    public function listar_entidades()
    {
        $tablas = $this->db->list_tables();
        $dataLayout = array();
        $dataPagina = array(
            "tablas" => $tablas,
        );
        $dataLayout["contenido"] = $this->load->view("crud_generator/listado_tablas", $dataPagina, TRUE);
        $this->load->view("layout/crud_generator/crud_generator", $dataLayout);
    }

    public function generar_entidad()
    {
        $tabla = $this->input->get("tabla");

        if (empty($tabla)) {
            show_error("Falta definir la tabla");
        }
        $columnas = $this->db->field_data($tabla);

        $dataLayout = array();
        $dataPagina = array(
            "inputs_disponibles" => $this->_get_tipo_inputs(),
            "relacion_input_tipo_columna" => $this->_get_relacion_input_tipo_columna(),
            "columnas" => $columnas,
        );
        $dataLayout["contenido"] = $this->load->view("crud_generator/form_generator", $dataPagina, TRUE);
        $this->load->view("layout/crud_generator/crud_generator", $dataLayout);
    }

    public function generar()
    {
        if ($this->input->post("generar") !== FALSE) {
            $this->_nombre_controlador = $this->input->post("entidad");
            $this->_nombre_model = $this->input->post("entidad") . "_model";
            $this->_nombre_tabla = $this->input->post("tabla");
            $this->_nombre_pk = $this->input->post("pk");
            $this->_ordenar_por_default = $this->input->post("ordenar_por");
            $this->_en_sentido_default = $this->input->post("en_sentido");
            $this->_campos = $this->input->post("campos");
            $this->_pisar_anterior = $this->input->post("pisar_anterior") === "S";

            $this->_generar_views();
            $this->_generar_controller();
            $this->_generar_model();
        }
    }

    private function _generar_views()
    {
        $ruta_views = VIEWPATH . "/" . $this->_nombre_controlador;
        if ( ! is_dir($ruta_views)) {
            mkdir($ruta_views, 0777, TRUE);
        }
        $this->_generar_listado($ruta_views);
        $this->_generar_form($ruta_views);
    }

    private function _generar_listado($ruta_views)
    {
        $ruta_listado = "{$ruta_views}/listado_" . $this->_nombre_controlador . ".php";
        $this->_reemplazar_archivo($ruta_listado);
        $campos = $this->_campos;
        $contenido_listado = file_get_contents(VIEWPATH . "/crud_generator/templates/crud_listado.tpl");
        $cabecera_listado = $this->_generar_cabercera_listado();
        $fila_listado = $this->_get_fila_listado();
        $search = array("{nombre_controlador}", "{cabecera}", "{fila}");
        $replace = array($this->_nombre_controlador, $cabecera_listado, $fila_listado);
        $listado = str_ireplace($search, $replace, $contenido_listado);
        file_put_contents($ruta_listado, $listado);
    }

    private function _generar_form($ruta_views)
    {
        $ruta_form = "{$ruta_views}/form_" . $this->_nombre_controlador . ".php";
        $this->_reemplazar_archivo($ruta_form);

        $contenido_form = file_get_contents(VIEWPATH . "/crud_generator/templates/crud_form.tpl");
        $inputs_form = $this->_generar_inputs_form();
        //echo $inputs_form;
        $search = array("{nombre_controlador}", "{inputs_form}");
        $replace = array($this->_nombre_controlador, $inputs_form);
        $form = str_ireplace($search, $replace, $contenido_form);
        file_put_contents($ruta_form, $form);
    }

    private function _generar_cabercera_listado()
    {
        $campos = $this->_campos;
        $cabecera = "<tr>" . PHP_EOL;
        $ruta_listado = "/{$this->_nombre_controlador}/listar";
        foreach ($campos as $nombre_campo => $data_campo) {
            if (element($data_campo, "mostrar_listado", 0) > 0) {
                if (element($data_campo, "puede_ordenar", 0) > 0) {
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
        $campos = $this->_campos;
        $fila = "<tr>" . PHP_EOL;
        foreach ($campos as $nombre_campo => $data_campo) {
            if (element($data_campo, "mostrar_listado", 0) > 0) {
                $fila .="<td><?php echo element(\$row, '{$nombre_campo}', ''); ?></td>" . PHP_EOL;
            }
        }
        $fila .="<td class='text-center'>"
            . "<div class='btn-group'>"
            . "     <a data-toggle='tooltip' title='editar' class='btn btn-xs btn-default' href='/{$this->_nombre_controlador}/editar/<?php echo element(\$row, '{$this->_nombre_pk}', 0); ?>'><?php echo glyphicon('edit'); ?></a>"
            . "     <a href='javascript:void(0)' data-toggle='tooltip' title='eliminar' class='btn btn-xs btn-danger'><?php echo glyphicon('trash'); ?></a>"
            . "</div>"
            . "</td>" . PHP_EOL;
        $fila .= "</tr>" . PHP_EOL;
        return $fila;
    }

    /* BK Original
      private function _get_fila_listado()
      {
      $campos = $this->_campos;
      $fila = "<tr>" . PHP_EOL;
      foreach ($campos as $nombre_campo => $data_campo) {
      if (element($data_campo, "mostrar_listado", 0) > 0) {
      $fila .="<td><?php echo element(\$row, '{$nombre_campo}', ''); ?></td>" . PHP_EOL;
      }
      }
      $fila .="<td><a href='/{$this->_nombre_controlador}/editar/<?php echo element(\$row, '{$this->_nombre_pk}', 0); ?>'>Editar</a></td>" . PHP_EOL;
      $fila .= "</tr>" . PHP_EOL;
      return $fila;
      } */

    public function test_html($tipo)
    {
        require_once APPPATH . "/libraries/Crud/HtmlElementFactory.php";
        $obj = HtmlElementFactory::crear_elemento($tipo);
        echo "<hr/>" . __FILE__ . " - " . __LINE__ . "<pre>";
        var_dump($obj);
        echo "</pre><hr/>";
        echo $obj->render("foo", "bar");
        die();
    }

    private function _generar_inputs_form()
    {
        echo "<hr/>" . __FILE__ . " - " . __LINE__ . "<pre>";
        //$config = $this->input->post("campos[id_provincia][config]");
//        $config_decode = (array) json_decode($config);
//        print_r($config_decode);
        print_r($this->_campos);
        echo "</pre><hr/>";
        //die;
        $html = "";
        $campos = $this->_campos;
        require_once APPPATH . "/libraries/Crud/HtmlElementFactory.php";
        foreach ($campos as $nombre_campo => $data_campo) {
            if (element($data_campo, "generar_input", 0) > 0) {
                $tipo_input = $data_campo["tipo_campo"];
                $config = $data_campo["config"];
                $html .="<div class='form-group'>" . PHP_EOL;
                if ($tipo_input !== "hidden") {
                    $html .="<label>" . element($data_campo, "label", "") . ":</label><br/>" . PHP_EOL;
                }
                $elemento_html = HtmlElementFactory::crear_elemento($tipo_input);
                if ( ! empty($config)) {
                    $config_decode = (array) json_decode($config);
                    $elemento_html->set_config($config_decode);
                }
                $html .= $elemento_html->render($nombre_campo) . PHP_EOL;
                $html .="</div>" . PHP_EOL;
            }
        }
        return $html;
    }

    private function _generar_inputs_form_bk()
    {
        $html = "";
        $campos = $this->_campos;
        foreach ($campos as $nombre_campo => $data_campo) {

            if (isset($data_campo["generar_input"]) AND (int) $data_campo["generar_input"] === 1) {
                $tipo_campo = $data_campo["tipo_campo"];
                $html.="<div>" . PHP_EOL;
                if ($tipo_campo !== "hidden") {
                    $html.="<label>" . element($data_campo, "label", "") . ":</label><br/>" . PHP_EOL;
                }

                if ($tipo_campo === "hidden") {
                    $html.="<input type='hidden' name='inputs[{$nombre_campo}]' value='<?php echo element(\$data,'{$nombre_campo}',0); ?>' />" . PHP_EOL;
                }
                if ($tipo_campo === "text") {
                    $html.="<input type='text' class='form-control' name='inputs[{$nombre_campo}]' value='<?php echo element(\$data,'{$nombre_campo}',''); ?>' />" . PHP_EOL;
                }
                if ($tipo_campo === "email") {
                    $html.="<input type='email' class='form-control' name='inputs[{$nombre_campo}]' value='<?php echo element(\$data,'{$nombre_campo}',''); ?>' />" . PHP_EOL;
                }
                if ($tipo_campo === "number") {
                    $html.="<input type='number' class='form-control' name='inputs[{$nombre_campo}]' value='<?php echo element(\$data,'{$nombre_campo}',''); ?>' />" . PHP_EOL;
                }
                if ($tipo_campo === "checkbox") {
                    $html.="<input type='checkbox' class='form-control' name='inputs[{$nombre_campo}]' value='1' />" . PHP_EOL;
                }
                if ($tipo_campo === "select") {
                    $html.="<select name='inputs[{$nombre_campo}]' class='form-control' ><option value=''>Seleccione...</option></select>" . PHP_EOL;
                }
                if ($tipo_campo === "textarea") {
                    $html.="<textarea name='inputs[{$nombre_campo}]' class='form-control' value='<?php echo element(\$data,'{$nombre_campo}',''); ?>' ></textarea>" . PHP_EOL;
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
        $this->_reemplazar_archivo($ruta_controller);
        file_put_contents($ruta_controller, $contenido);
    }

    private function _generar_model()
    {
        $tpl = file_get_contents(VIEWPATH . "/crud_generator/templates/crud_model.tpl");
        $search = array("{nombre_model}", "{nombre_tabla}", "{nombre_pk}");
        $replace = array(ucfirst($this->_nombre_model), $this->_nombre_tabla, $this->_nombre_pk);
        $contenido = str_ireplace($search, $replace, $tpl);
        $ruta_model = APPPATH . "/models/" . ucfirst($this->_nombre_model) . ".php";
        $this->_reemplazar_archivo($ruta_model);
        file_put_contents($ruta_model, $contenido);
    }

    /**
     * Devuelve un array de los tipos de inputs disponibles para generar en un form
     * con un formato para poder armar un select.
     * Ej: array('textarea' => '<textarea></textarea>', 'text' => '<input type='text' />')
     * @return string
     */
    private function _get_tipo_inputs()
    {
        $tipos_input = array(
            "textarea" => "textarea",
            "number" => "input type='number'",
            "text" => "input type='text'",
            "email" => "input type='email'",
            "hidden" => "input type='hidden'",
            "checkbox" => "input type='checkbox'",
            "select" => "select",
            "select_fk" => "select FK",
        );
        return $tipos_input;
    }

    /**
     * Devuelve un array de relacion entre el tipo de campo en la db y el tipo de
     * input que tomará por default
     * @return string
     */
    private function _get_relacion_input_tipo_columna()
    {
        //$key => tipo_input
        //$value => field_type que devuelve el mysql
        $relacion_input_tipo_columna = array(
            "text" => "textarea",
            "varchar" => "text",
            "int" => "number",
            "smallint" => "number",
            "char" => "text"
        );
        return $relacion_input_tipo_columna;
    }

    private function _reemplazar_archivo($ruta_archivo)
    {
        if (is_file($ruta_archivo)) {
            if ($this->_pisar_anterior) {
                unlink($ruta_archivo);
            } else {
                rename($ruta_archivo, "{$ruta_archivo}.old_" . date("Ymd_his"));
            }
        }
    }

}
