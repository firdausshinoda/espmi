<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sistem extends CI_Controller {

	public function __construct() {
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		if (isset($this->session->userdata['espmi-superadmin'])==TRUE){
			redirect(base_url('Superadmin'));
		} else if (isset($this->session->userdata['espmi-admin'])==TRUE){
			redirect(base_url('Admin'));
		} else if (isset($this->session->userdata['espmi-user'])==TRUE){
			redirect(base_url('User'));
		}
	}

	public function index() {
		$this->load->view('signin');
	}

	public function auth(){
		$status = "WRONG";
		$url = null;
		$nipy = post('nipy');
		$password = post('password');
		$ck_admin = db_where('tb_admin',array('nipy'=>$nipy));
		$ck_user = db_where('tb_user',array('nipy'=>$nipy));
		if ($ck_admin->num_rows() > 0){
			$dt = $ck_admin->row();
			if ($dt->password == md5($password)){
				if ($dt->jenis_admin=="SUPERADMIN"){
					$session['espmi-superadmin'] = TRUE;
					$url = base_url('Superadmin');
					$session['id_unit']	= 12;
				} else {
					$session['espmi-admin'] = TRUE;
					$url = base_url('Admin');
				}
				$session['id']		= $dt->id_tb_admin;
				$session['id_unit']	= $dt->id_tb_unit;
				$session['jenis_unit']	= $dt->jenis_unit;
				$session['nipy']	= $dt->nipy;
				$session['nama']	= $dt->nama_admin;
				$session['foto']	= $dt->foto_admin;
				sess_set($session);
				$status = "OK";
			} else {
				$status = "WRONG";
			}
		} else if ($ck_user->num_rows() > 0){
			$dt = $ck_user->row();
			if ($dt->password == md5($password)){
				$session['espmi-user'] = TRUE;
				$session['id']		= $dt->id_tb_user;
				$session['nipy']	= $dt->nipy;
				$session['nama']	= $dt->nama_user;
				$session['foto']	= $dt->foto_user;
				sess_set($session);
				$url = base_url('User');
				$status = "OK";
			} else {
				$status = "WRONG";
			}
		} else {
			$status = "NO-EXIST";
		}
		$response = array(
			'csrfName'	=> $this->security->get_csrf_token_name(),
			'csrfHash'	=> $this->security->get_csrf_hash(),
			'url'		=> $url
		);
		setResponseJson($status,$response);
	}
}
