<?php

/**
 *
 * @param type $aData
 * @param type $sNombre
 * @param type $mDefault
 * @return el  valor del elemento del array o el valor seteado por default o NULL si no fue seteado nada
 */
function get_value($aData, $sNombre, $mDefault = NULL)
{
    if (isset($aData[$sNombre])) {
        return $aData[$sNombre];
    } elseif (isset($_POST[$sNombre])) {
        return $_POST[$sNombre];
    } else if ($mDefault !== NULL) {
        return $mDefault;
    } else {
        return '';
    }
}

/**
 * Devuelve el valor en formato dd-mm-yyyy para un input de tipo fecha
 * @param type $aData
 * @param type $sNombre
 * @param type $mDefault
 * @return type
 */
function get_value_fecha($aData, $sNombre, $mDefault = '')
{
    $default = isset($mDefault) ? $mDefault : '';
    return (isset($aData[$sNombre]) AND $aData[$sNombre] !== "0000-00-00" ) ? mysql_to_human_date($aData[$sNombre], '-') : $default;
}

if ( ! function_exists('option')) {

    /**
     * Arma y devuelve un elemtno <option>
     * @param mixed $mValue [int | string] El value del option
     * @param mixed $mText [int | string] El text del option
     * @param mixed $mSelected  [array | int | string ]Los elementos seleccionados. Puede ser un array o valor atómico.
     * @return string El elemento option armado.
     */
    function option($mValue, $mText, $mSelected, $bDisabled = FALSE)
    {
        $selected = "";
        $disabled = (bool) $bDisabled === TRUE ? "disabled" : "";
        if (is_array($mSelected)) {
            if (in_array($mValue, $mSelected)) {
                $selected = 'selected="selected"';
            }
        } else {
            if ((string) $mValue === (string) $mSelected) {
                $selected = 'selected="selected"';
            }
        }

        return '<option value="' . $mValue . '" ' . $selected . ' ' . $disabled . '>' . $mText . '</option>';
    }

}


if ( ! function_exists('checkbox')) {

    /**
     * Arma y devuelve un elemtno <checkbox>
     * @param mixed $mValue [int | string] El value del checkbox
     * @param mixed $mName [string] El atributo name del input
     * @param mixed $mSelected  [array | int | string ]Los elementos seleccionados. Puede ser un array o valor atómico.
     * @return string El elemento option armado.
     */
    function checkbox($mValue, $mName, $mSelected)
    {
        $selected = "";
        if (is_array($mSelected)) {
            if (in_array($mValue, $mSelected)) {
                $selected = 'checked="checked"';
            }
        } else {
            if ((string) $mValue === (string) $mSelected) {
                $selected = 'checked="checked"';
            }
        }

        return '<input type="checkbox" name="' . $mName . '" value="' . $mValue . '" ' . $selected . '/>';
    }

}