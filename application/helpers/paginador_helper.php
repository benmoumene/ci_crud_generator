<?php

function init_pagination($uri, $total_rows, $per_page = 10, $segment = 4)
{
    $ci = & get_instance();
    $config['per_page'] = $per_page;
    $config['uri_segment'] = $segment;
    $config['base_url'] = base_url() . $uri;
    $config['total_rows'] = $total_rows;
    $config['use_page_numbers'] = TRUE;
    $config['reuse_query_string'] = TRUE;
    $config['first_tag_open'] = $config['last_tag_open'] = $config['next_tag_open'] = $config['prev_tag_open'] = $config['num_tag_open'] = '<li>';
    $config['first_tag_close'] = $config['last_tag_close'] = $config['next_tag_close'] = $config['prev_tag_close'] = $config['num_tag_close'] = '</li>';

    $config['num_links'] = 3;
    $config['first_link'] = 'Primero';
    $config['last_link'] = '&Uacute;ltimo';

    $config['cur_tag_open'] = "<li class='active'><span><b>";
    $config['cur_tag_close'] = "</b></span></li>";
    $ci->pagination->initialize($config);
    return $config;
}
