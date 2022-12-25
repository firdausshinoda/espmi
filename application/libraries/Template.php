<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Template{
	protected $_CI;

	function __construct(){
		$this->_CI = &get_instance();
	}

	function template_superadmin($template, $data = null){
		$data['content'] = $this->_CI->load->view($template, $data, true);
		$this->_CI->load->view('style/template_superadmin', $data);
	}

	function template_admin($template, $data = null){
		$data['content'] = $this->_CI->load->view($template, $data, true);
		$this->_CI->load->view('style/template_admin', $data);
	}

	function template_user($template, $data = null){
		$data['content'] = $this->_CI->load->view($template, $data, true);
		$this->_CI->load->view('style/template_user', $data);
	}
}
