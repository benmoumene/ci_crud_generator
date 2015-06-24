<?php

// ------------------------------------------------------------------------

/**
 * Assets URL
 *
 * Crea una url local para localizar los elementos que están dentro del directorio assets
 *
 * @access	public
 * @param string
 * @return	string
 */
if ( ! function_exists('asset_url')) {

    function asset_url()
    {
        $CI = & get_instance();
        return $CI->config->base_url() . "/assets/";
    }

}