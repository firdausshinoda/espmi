<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Superadmin extends CI_Controller {

	public function __construct() {
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->library('template');
		$this->load->model('M_api');
		if (isset($this->session->userdata['espmi-superadmin'])!=TRUE){
			redirect(base_url());
		}
	}

	public function index() {
		$data['jenis_dokumen'] = db_where('tb_jenis_dokumen',array('del_flage'=>1))->result();
		$this->template->template_superadmin('superadmin/dokumen/index_dashboard',$data);
	}

	public function dokumen() {
		$data = array();
		$page = get('page');
		$type = get('type');

		if (empty($type)){
			if (empty($page)){
				$data['jenis_dokumen'] = db_where('tb_jenis_dokumen',array('del_flage'=>1))->result();
				$file_v = "index_dashboard";
			} elseif ($page=="detail") {
				$file_v = "detail";
			} elseif ($page=="edit") {
				$file_v = "edit_dashboard";
			}
		} else if ($type=="standar-spmi"){
			if (empty($page)){
				$file_v = "index_standar_spmi";
			} elseif ($page=="new") {
				$file_v = "new_standar_spmi";
			} elseif ($page=="detail") {
				$file_v = "detail";
			} elseif ($page=="edit") {
				$file_v = "edit_standar_spmi";
			}
		} else if ($type=="manual-mutu-penetapan"){
			if (empty($page)){
				$file_v = "index_manmu_penetapan";
			} elseif ($page=="new") {
				$file_v = "new_manmu_penetapan";
			} elseif ($page=="detail") {
				$file_v = "detail";
			} elseif ($page=="edit") {
				$file_v = "edit_manmu_penetapan";
			}
		} else if ($type=="manual-mutu-pelaksanaan"){
			if (empty($page)){
				$file_v = "index_manmu_pelaksanaan";
			} elseif ($page=="new") {
				$file_v = "new_manmu_pelaksanaan";
			} elseif ($page=="detail") {
				$file_v = "detail";
			} elseif ($page=="edit") {
				$file_v = "edit_manmu_pelaksanaan";
			}
		} else if ($type=="manual-mutu-evaluasi"){
			if (empty($page)){
				$file_v = "index_manmu_evaluasi";
			} elseif ($page=="new") {
				$file_v = "new_manmu_evaluasi";
			} elseif ($page=="detail") {
				$file_v = "detail";
			} elseif ($page=="edit") {
				$file_v = "edit_manmu_evaluasi";
			}
		} else if ($type=="manual-mutu-pengendalian"){
			if (empty($page)){
				$file_v = "index_manmu_pengendalian";
			} elseif ($page=="new") {
				$file_v = "new_manmu_pengendalian";
			} elseif ($page=="detail") {
				$file_v = "detail";
			} elseif ($page=="edit") {
				$file_v = "edit_manmu_pengendalian";
			}
		} else if ($type=="manual-mutu-peningkatan"){
			if (empty($page)){
				$file_v = "index_manmu_peningkatan";
			} elseif ($page=="new") {
				$file_v = "new_manmu_peningkatan";
			} elseif ($page=="detail") {
				$file_v = "detail";
			} elseif ($page=="edit") {
				$file_v = "edit_manmu_peningkatan";
			}
		} else if ($type=="formulir"){
			if (empty($page)){
				$file_v = "index_formulir";
			} elseif ($page=="new") {
				$file_v = "new_formulir";
			} elseif ($page=="detail") {
				$file_v = "detail";
			} elseif ($page=="edit") {
				$file_v = "edit_formulir";
			}
		} else if ($type=="kebijakan"){
			if (empty($page)){
				$file_v = "index_kebijakan";
			} elseif ($page=="new") {
				$file_v = "new_kebijakan";
			} elseif ($page=="detail") {
				$file_v = "detail";
			} elseif ($page=="edit") {
				$file_v = "edit_kebijakan";
			}
		} else if ($type=="dok-institusi"){
			if (empty($page)){
				$data['jenis_dokumen'] = db_where('tb_jenis_dokumen',array('tipe_dokumen'=>"DOKUMEN INSTITUSI",'del_flage'=>1))->result();
				$file_v = "index_dokinstitusi";
			} elseif ($page=="new") {
				$file_v = "new_dokinstitusi";
			} elseif ($page=="detail") {
				$file_v = "detail";
			} elseif ($page=="edit") {
				$file_v = "edit_dokinstitusi";
			}
		}

		if ($page=="detail" || $page=="edit"){
			$stmt = $this->M_api->api_detailDokumen(array('tb_dokumen.id_tb_dokumen'=>get('id')))->row();
			$data['detail'] = $stmt;
			$data['data_unit_terkait'] = db_where('tb_dokumen_unit_terkait',array('id_tb_dokumen'=>$stmt->id_tb_dokumen,'id_tb_unit'=>sess_get('id_unit')))->row();
		}
		$this->template->template_superadmin('superadmin/dokumen/'.$file_v,$data);
	}

	public function notification() {
		$data = array();
		$page = get('page');
		if (empty($page)){
			$file_v = "notification";
		} else if ($page=="detail"){
			$file_v = "notification-detail";
		} else if ($page=="edit"){
			$file_v = "notification-edit";
		}
		if ($page=="detail" || $page=="edit"){
			$stmt = $this->M_api->api_detailKonsultasi(array('tb_konsultasi.id_tb_konsultasi'=>get('id')))->row();
			$data['detail'] = $stmt;
			$data['data_unit_terkait'] = db_where('tb_konsultasi_unit_terkait',array('id_tb_konsultasi'=>$stmt->id_tb_konsultasi,'id_tb_unit'=>sess_get('id_unit')))->row();
			$data['data_revisi'] = $this->M_api->api_getRevisiAdmin(get('id'))->result();
		}
		$this->template->template_superadmin('superadmin/notification/'.$file_v,$data);
	}

	public function konsultasi() {
		$data = array();
		$page = get('page');
		if (empty($page)){
			$file_v = "index";
		} else if ($page=="detail"){
			$file_v = "detail";
		} else if ($page=="edit"){
			$file_v = "edit";
		}
		if ($page=="detail" || $page=="edit"){
			$stmt = $this->M_api->api_detailKonsultasi(array('tb_konsultasi.id_tb_konsultasi'=>get('id')))->row();

			$uploadPath = "./assets/dokumen/konsultasi/";
			if (file_exists($uploadPath.$stmt->file)) {
				$data['stt_file'] = true;
			} else {
				$data['stt_file'] = false;
			}

			$data['detail'] = $stmt;
			$data['data_unit_terkait'] = db_where('tb_konsultasi_unit_terkait',array('id_tb_konsultasi'=>$stmt->id_tb_konsultasi,'id_tb_unit'=>sess_get('id_unit')))->row();
			$data['data_revisi'] = $this->M_api->api_getRevisiAdmin(get('id'))->result();
		}
		$this->template->template_superadmin('superadmin/konsultasi/'.$file_v,$data);
	}

	public function pengguna() {
		$type = get('type');
		$page = get('page');
		if (empty($type)){
			$file_v = "superadmin/index";
		} else if ($type=="superadmin"){
			if (empty($page)){
				$file_v = "superadmin/index";
			} elseif ($page=="new"){
				$file_v = "superadmin/new";
			} elseif ($page=="detail"){
				$file_v = "superadmin/detail";
			} elseif ($page=="edit"){
				$file_v = "superadmin/edit";
			}
		} else if ($type=="admin"){
			if (empty($page)){
				$file_v = "admin/index";
			} elseif ($page=="new"){
				$file_v = "admin/new";
			} elseif ($page=="detail"){
				$file_v = "admin/detail";
			} elseif ($page=="edit"){
				$file_v = "admin/edit";
			}
		} else if ($type=="user"){
			if (empty($page)){
				$file_v = "user/index";
			} elseif ($page=="new"){
				$file_v = "user/new";
			} elseif ($page=="detail"){
				$file_v = "user/detail";
			} elseif ($page=="edit"){
				$file_v = "user/edit";
			}
		}
		$this->template->template_superadmin('superadmin/pengguna/'.$file_v);
	}

	public function dafunit() {
		$page = get('page');
		if (empty($page)){
			$file_v = "index";
		} else if ($page=="new"){
			$file_v = "new";
		} else if ($page=="detail"){
			$file_v = "detail";
		} else if ($page=="edit"){
			$file_v = "edit";
		}
		$this->template->template_superadmin('superadmin/daftar-unit/'.$file_v);
	}

	public function jendok(){
		$page = get('page');
		$data = array();
		if (empty($page)){
			$file_v = "index";
		} elseif ($page=="new"){
			$file_v = "new";
		} elseif ($page=="edit"){
			$file_v = "edit";
			$ck = db_where('tb_jenis_dokumen',array('id_tb_jenis_dokumen'=>get('id')));
			if ($ck->num_rows() == 0){
				redirect(site_url('Superadmin/jendok'));
			}
			$data['detail'] = $ck->row();
		} elseif ($page=="detail"){
			$file_v = "detail";
			$ck = db_where('tb_jenis_dokumen',array('id_tb_jenis_dokumen'=>get('id')));
			if ($ck->num_rows() == 0){
				redirect(site_url('Superadmin/jendok'));
			}
			$data['detail'] = $ck->row();
		}
		$this->template->template_superadmin('superadmin/jenis-dokumen/'.$file_v,$data);
	}

	public function nodok() {
		$page = get('page');
		$data = array();
		if (empty($page)){
			$file_v = "index";
		} elseif ($page=="new"){
			$file_v = "new";
		} elseif ($page=="edit"){
			$file_v = "edit";
			$ck = $this->M_api->api_detailNoDok(array('tb_dokumen_kode.id_tb_dokumen_kode'=>get('id')));
			if ($ck->num_rows() == 0){
				redirect(site_url('Superadmin/nodok'));
			}
			$data['detail'] = $ck->row();
		} elseif ($page=="detail"){
			$file_v = "detail";
			$ck = $this->M_api->api_detailNoDok(array('tb_dokumen_kode.id_tb_dokumen_kode'=>get('id')));
			if ($ck->num_rows() == 0){
				redirect(site_url('Superadmin/nodok'));
			}
			$data['detail'] = $ck->row();
		}
		$this->template->template_superadmin('superadmin/nodok/'.$file_v,$data);
	}

	public function laporan() {
		$type = get('type');
		$data = array();
		if (empty($type) || $type=="list-dokumen"){
			$file_v = "list-dokumen";
		} else if ($type=="list-konsultasi"){
			$file_v = "list-konsultasi";
		} else if ($type=="list-jendok"){
			$file_v = "list-jendok";
		}  else if ($type=="list-nodok"){
			$file_v = "list-nodok";
		} else if ($type=="list-unit"){
			$file_v = "list-unit";
		} else if ($type=="list-user-unit"){
			$file_v = "list-user-unit";
		} else if ($type=="list-user-view"){
			$file_v = "list-user-view";
		}
		$this->template->template_superadmin('superadmin/laporan/'.$file_v,$data);
	}

	public function profil(){
		$this->template->template_superadmin('superadmin/profil/index');
	}

	public function download(){
		$location = "konsultasi";
		$ext = get('ext');
		if (!empty(get('status'))){
			$location = "dokumen";
			$ext = "pdf";
		}
		$nama = get('nama').".".$ext;
		$file = get('file');
		force_download($nama,file_get_contents("assets/upload/dokumen/$location/$file"));
	}

	public function modal(){
		$page = get('page');
		if ($page == "revisi"){
			$data['id_konsultasi_unit_terkait'] = get('str1');
		}
		$data['page'] = $page;
		$this->load->view('superadmin/modal',$data);
	}

	public function sign_out(){
		$this->session->sess_destroy();
		redirect(base_url());
	}
}
