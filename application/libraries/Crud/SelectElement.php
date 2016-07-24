<?php

require_once APPPATH . '/libraries/Crud/AbstractHtmlElement.php';

/**
 * 25/06/2015
 * File: SelectElement.php
 * Encoding: ISO-8859-1
 * Project: ci_crud_generator
 * Description of SelectElement
 *
 * @author Diego Olmedo
 */
class SelectElement extends AbstractHtmlElement
{

    public function __construct()
    {

    }

    public function render($name, $id = "")
    {
        $options = $this->_render_options($name);
        return "<select name='inputs[{$name}]' id='{$id}'>"
            . "{$options}"
            . "</select>";
    }

    protected function _render_options($name)
    {
        if ( ! empty($this->_config)) {
            $options = $this->_config;
            $options_to_render = "<?php " . PHP_EOL;

            foreach ($options as $oDataOption) {
                $data_option = (array) $oDataOption;
                if ((int) $data_option["selected"] === 1) {
                    $selected_option = $data_option["value"];
                    break;
                }
            }
            foreach ($options as $oDataOption) {
                $data_option = (array) $oDataOption;
                $elementa_data = 'element($data, "' . $name . '","' . $selected_option . '")';
                $options_to_render .= "echo option('{$data_option["value"]}', '{$data_option["text"]}', {$elementa_data}); " . PHP_EOL;
            }

            $options_to_render .= "?>" . PHP_EOL;
            return $options_to_render;
        }
    }

}
