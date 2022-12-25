<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	public function __construct() {
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->library('template');
		$this->load->model('M_api');
		if (isset($this->session->userdata['espmi-user'])!=TRUE){
			redirect(base_url());
		}
	}

	public function index(){
		$page = get('page');
		$data = array();
		if (empty($page)){
			$data['jenis_dokumen'] = db_where('tb_jenis_dokumen',array('del_flage'=>1))->result();
			$page = 'index';
		} else {
			$page = 'detail';
			$stmt = $this->M_api->api_detailDokumen(array('tb_dokumen.id_tb_dokumen'=>get('id')))->row();
			$data['detail'] = $stmt;
		}
		$this->template->template_user('user/dashboard/'.$page,$data);
	}

	public function profil(){
		$this->template->template_user('user/profil/index');
	}

	public function modal(){
		$page = get('page');
		$data['page'] = $page;
		$this->load->view('user/modal',$data);
	}

	public function sign_out(){
		$this->session->sess_destroy();
		redirect(base_url());
	}
}
