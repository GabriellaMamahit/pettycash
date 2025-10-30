<?php

class Template
{

    var $template_data = array();
    protected $CI; // Menyimpan instance CI dalam properti protected

    function set($name, $value)
    {
        $this->template_data[$name] = $value;
    }

    function load($template = '', $view = '', $view_data = array(), $return = FALSE)
    {
        $this->CI = CI_Controller::get_instance(); // Mengakses instance CI
        $this->set('contents', $this->CI->load->view($view, $view_data, TRUE));
        return $this->CI->load->view($template, $this->template_data, $return);
    }
}