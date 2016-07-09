<?php
require_once APPPATH . '/libraries/Crud/Generadores/AbstractGenerador.php';

/**
 * 09-jul-2016
 * File: Generador_form.php
 * Encoding: ISO-8859-1
 * Project: ci_crud_generator
 * Description of Generador_form
 *
 * @author Diego Olmedo
 */
class Generador_Form extends AbstractGenerador
{

    public function generar($ruta_views)
    {
        $nombre_controlador = $this->_oConfigEntidad->nombre_controlador;
        $pisar_form = $this->_oConfigEntidad->pisar_view_form_anterior;
        $ruta_form = "{$ruta_views}/form_" . $nombre_controlador . ".php";
        $this->_reemplazar_archivo($ruta_form, $pisar_form);

        $contenido_form = file_get_contents(VIEWPATH . "/crud_generator/templates/crud_form.tpl");
        $inputs_form = $this->_generar_inputs_form();
        //echo $inputs_form;
        $search = array("{nombre_controlador}", "{inputs_form}");
        $replace = array($nombre_controlador, $inputs_form);
        $form = str_ireplace($search, $replace, $contenido_form);
        file_put_contents($ruta_form, $form);
    }

    private function _generar_inputs_form()
    {
        $campos = $this->_oConfigEntidad->campos;
        //echo "<hr/>" . __FILE__ . " - " . __LINE__ . "<pre>";
        //echo "<hr/><pre>";
        // print_r($this->input->post());
        //echo "</pre><hr/>";
        //die();
        //$config = $this->input->post("campos[id_provincia][config]");
//        $config_decode = (array) json_decode($config);
//        print_r($config_decode);
//        print_r($campos);
//        echo "</pre><hr/>";
        //die;
        $html = "";
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

}
