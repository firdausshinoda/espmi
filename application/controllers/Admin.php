<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct() {
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->library('template');
		$this->load->model('M_api');
		if (isset($this->session->userdata['espmi-admin'])!=TRUE){
			redirect(base_url());
		}
	}

	public function index() {
		$data['jenis_dokumen'] = db_where('tb_jenis_dokumen',array('del_flage'=>1))->result();
		$this->template->template_admin('admin/dokumen/index_dashboard',$data);
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
			}
		} else if ($type=="standar-spmi"){
			if (empty($page)){
				$file_v = "index_standar_spmi";
			} elseif ($page=="detail") {
				$file_v = "detail";
			}
		} else if ($type=="manual-mutu-penetapan"){
			if (empty($page)){
				$file_v = "index_menu_penetapan";
			} elseif ($page=="detail") {
				$file_v = "detail";
			}
		} else if ($type=="manual-mutu-pelaksanaan"){
			if (empty($page)){
				$file_v = "index_menu_pelaksanaan";
			} elseif ($page=="detail") {
				$file_v = "detail";
			}
		} else if ($type=="manual-mutu-evaluasi"){
			if (empty($page)){
				$file_v = "index_menu_evaluasi";
			} elseif ($page=="detail") {
				$file_v = "detail";
			}
		} else if ($type=="manual-mutu-pengendalian"){
			if (empty($page)){
				$file_v = "index_menu_pengendalian";
			} elseif ($page=="detail") {
				$file_v = "detail";
			}
		} else if ($type=="manual-mutu-peningkatan"){
			if (empty($page)){
				$file_v = "index_menu_peningkatan";
			} elseif ($page=="detail") {
				$file_v = "detail";
			}
		} else if ($type=="formulir"){
			if (empty($page)){
				$file_v = "index_formulir";
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
		if ($type=="dok-institusi"){
			$data['btn_add'] = true;
		}
		$this->template->template_admin('admin/dokumen/'.$file_v,$data);
	}

	public function notification() {
		$data = array();
		$page = get('page');
		if (empty($page)){
			$file_v = "notification";
		} else if ($page=="detail"){
			$stmt = $this->M_api->api_detailKonsultasi(array('tb_konsultasi.id_tb_konsultasi'=>get('id')))->row();

			$stt_revisi = FALSE;
			foreach (db_where('tb_konsultasi_unit_terkait',array('id_tb_konsultasi'=>get('id')))->result() as $it){
				if ($it->stt_revisi_unit == "REVISI"){
					$stt_revisi = TRUE;
				}
			}
			$data['stt_revisi'] = $stt_revisi;
			$data['detail'] = $stmt;
			$data['data_unit_terkait'] = db_where('tb_konsultasi_unit_terkait',array('id_tb_konsultasi'=>$stmt->id_tb_konsultasi,'id_tb_unit'=>sess_get('id_unit')))->row();
			$data['data_revisi'] = $this->M_api->api_getRevisiAdmin(get('id'))->result();
			$file_v = "notification-detail";
		}
		$this->template->template_admin('admin/notification/'.$file_v,$data);
	}

	public function dokspmi() {
		$type = get('type');
		$page = get('page');
		$data = array();
		$stmt = null;
		if (empty($type)){
			$file_v = "standar/index";
		} else if ($type=="standar"){
			if (empty($page)){
				$data['ttl'] = db_where('tb_dokumen',array('del_flage'=>1,'jenis_dokumen'=>"Standar SPMI",'id_tb_admin'=>sess_get('id')))->num_rows();
				$file_v = "index";
			} else if ($page=="new") {
				$file_v = "standar/new";
			} else if ($page=="detail") {
				$file_v = "detail";
				$stmt = $this->M_api->api_detailDokumen(array('tb_dokumen.id_tb_dokumen'=>get('id')))->row();
				$data['dokumen'] = $stmt;
			} else if ($page=="edit") {
				$file_v = "standar/edit";
				$data['dokumen'] = $this->M_api->api_detailDokumen(array('tb_dokumen.id_tb_dokumen'=>get('id')))->row();
			}
		}  else if ($type=="manual-mutu-penetapan"){
			if (empty($page)){
				$data['ttl'] = db_where('tb_dokumen',array('del_flage'=>1,'jenis_dokumen'=>"Manual Mutu Penetapan",'id_tb_admin'=>sess_get('id')))->num_rows();
				$file_v = "index";
			} else if ($page=="new") {
				$file_v = "manual-mutu/penetapan-new";
			} else if ($page=="detail") {
				$file_v = "detail";
				$stmt = $this->M_api->api_detailDokumen(array('tb_dokumen.id_tb_dokumen'=>get('id')))->row();
				$data['dokumen'] = $stmt;
			}
		}  else if ($type=="manual-mutu-pelaksanaan"){
			if (empty($page)){
				$data['ttl'] = db_where('tb_dokumen',array('del_flage'=>1,'jenis_dokumen'=>"Manual Mutu Pelaksanaan",'id_tb_admin'=>sess_get('id')))->num_rows();
				$file_v = "index";
			} else if ($page=="new") {
				$file_v = "manual-mutu/pelaksanaan-new";
			} else if ($page=="detail") {
				$file_v = "detail";
				$stmt = $this->M_api->api_detailDokumen(array('tb_dokumen.id_tb_dokumen'=>get('id')))->row();
				$data['dokumen'] = $stmt;
			}
		}  else if ($type=="manual-mutu-evaluasi"){
			if (empty($page)){
				$data['ttl'] = db_where('tb_dokumen',array('del_flage'=>1,'jenis_dokumen'=>"Manual Mutu Evaluasi",'id_tb_admin'=>sess_get('id')))->num_rows();
				$file_v = "index";
			} else if ($page=="new") {
				$file_v = "manual-mutu/evaluasi-new";
			} else if ($page=="detail") {
				$file_v = "detail";
				$stmt = $this->M_api->api_detailDokumen(array('tb_dokumen.id_tb_dokumen'=>get('id')))->row();
				$data['dokumen'] = $stmt;
			}
		}  else if ($type=="manual-mutu-pengendalian"){
			if (empty($page)){
				$data['ttl'] = db_where('tb_dokumen',array('del_flage'=>1,'jenis_dokumen'=>"Manual Mutu Pengendalian",'id_tb_admin'=>sess_get('id')))->num_rows();
				$file_v = "index";
			} else if ($page=="new") {
				$file_v = "manual-mutu/pengendalian-new";
			} else if ($page=="detail") {
				$file_v = "detail";
				$stmt = $this->M_api->api_detailDokumen(array('tb_dokumen.id_tb_dokumen'=>get('id')))->row();
				$data['dokumen'] = $stmt;
			}
		}  else if ($type=="manual-mutu-peningkatan"){
			if (empty($page)){
				$data['ttl'] = db_where('tb_dokumen',array('del_flage'=>1,'jenis_dokumen'=>"Manual Mutu Peningkatan",'id_tb_admin'=>sess_get('id')))->num_rows();
				$file_v = "index";
			} else if ($page=="new") {
				$file_v = "manual-mutu/peningkatan-new";
			} else if ($page=="detail") {
				$file_v = "detail";
				$stmt = $this->M_api->api_detailDokumen(array('tb_dokumen.id_tb_dokumen'=>get('id')))->row();
				$data['dokumen'] = $stmt;
			}
		} else if ($type=="formulir"){
			if (empty($page)){
				$data['ttl'] = db_where('tb_dokumen',array('del_flage'=>1,'jenis_dokumen'=>"Formulir",'id_tb_admin'=>sess_get('id')))->num_rows();
				$file_v = "index";
			} else if ($page=="new") {
				$file_v = "formulir/new";
			} else if ($page=="detail") {
				$file_v = "detail";
				$stmt = $this->M_api->api_detailDokumen(array('tb_dokumen.id_tb_dokumen'=>get('id')))->row();
				$data['dokumen'] = $stmt;
			}
		} else if ($type=="kebijakan"){
			if (empty($page)){
				$data['ttl'] = db_where('tb_dokumen',array('del_flage'=>1,'jenis_dokumen'=>"Kebijakan",'id_tb_admin'=>sess_get('id')))->num_rows();
				$file_v = "index";
			} else if ($page=="new"){
				$file_v = "new";
			} else if ($page=="detail"){
				$file_v = "detail";
				$stmt = $this->M_api->api_detailDokumen(array('tb_dokumen.id_tb_dokumen'=>get('id')))->row();
				$data['dokumen'] = $stmt;
			}
		}
		if ($stmt!=null){
			if ($stmt->jenis_dokumen=="Standar SPMI"){
				$jenis_dokumen = "standar";
			} else if ($stmt->jenis_dokumen=="Manual Mutu Penetapan"){
				$jenis_dokumen = "manual-mutu-penetapan";
			} else if ($stmt->jenis_dokumen=="Manual Mutu Pelaksanaan"){
				$jenis_dokumen = "manual-mutu-pelaksanaan";
			} else if ($stmt->jenis_dokumen=="Manual Mutu Evaluasi"){
				$jenis_dokumen = "manual-mutu-evaluasi";
			} else if ($stmt->jenis_dokumen=="Manual Mutu Pengendalian"){
				$jenis_dokumen = "manual-mutu-pengendalian";
			} else if ($stmt->jenis_dokumen=="Manual Mutu Peningkatan"){
				$jenis_dokumen = "manual-mutu-peningkatan";
			} else if ($stmt->jenis_dokumen=="Formulir"){
				$jenis_dokumen = "formulir";
			} else if ($stmt->jenis_dokumen=="Kebijakan"){
				$jenis_dokumen = "kebijakan";
			}
			$data['jenis_dokumen'] = $jenis_dokumen;
		}
		$this->template->template_admin('admin/dokspmi/'.$file_v,$data);
	}

	public function kebijakan() {
		$page = get('page');
		if (empty($page)){
			$file_v = "index";
		} else if ($page=="new"){
			$file_v = "new";
		} else if ($page=="detail"){
			$file_v = "detail";
		}
		$this->template->template_admin('admin/kebijakan/'.$file_v);
	}

	public function konsultasi() {
		$data = array();
		$page = get('page');
		if (empty($page)){
			$file_v = "index";
		} else if ($page=="new"){
			$file_v = "new";
		} else if ($page=="detail"){
			$file_v = "detail";
			$stt_revisi = FALSE;
			foreach (db_where('tb_konsultasi_unit_terkait',array('id_tb_konsultasi'=>get('id')))->result() as $it){
				if ($it->stt_revisi_unit == "REVISI"){
					$stt_revisi = TRUE;
				}
			}
			$data['stt_revisi'] = $stt_revisi;
			$data['data_revisi'] = $this->M_api->api_getRevisiAdmin(get('id'))->result();
		} else if ($page=="edit"){
			$file_v = "edit";
		}
		if ($page=="detail" || $page=="edit"){
			$stmt = $this->M_api->api_detailKonsultasi(array('tb_konsultasi.id_tb_konsultasi'=>get('id')))->row();
			$data['detail'] = $stmt;
		}
		$this->template->template_admin('admin/konsultasi/'.$file_v,$data);
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
				redirect(site_url('Admin/nodok'));
			}
			$data['detail'] = $ck->row();
		} elseif ($page=="detail"){
			$file_v = "detail";
			$ck = $this->M_api->api_detailNoDok(array('tb_dokumen_kode.id_tb_dokumen_kode'=>get('id')));
			if ($ck->num_rows() == 0){
				redirect(site_url('Admin/nodok'));
			}
			$data['detail'] = $ck->row();
		}
		$this->template->template_admin('admin/nodok/'.$file_v,$data);
	}

	public function profil(){
		$this->template->template_admin('admin/profil/index');
	}

	public function download(){
		$nama = get('nama').".".get('ext');
		$type = get('type');
		$file = get('file');
		force_download($nama,file_get_contents("assets/upload/dokumen/konsultasi/$file"));
	}

	public function modal(){
		$page = get('page');
		if ($page == "revisi"){
			$data['id_konsultasi_unit_terkait'] = get('str1');
		}
		$data['page'] = $page;
		$this->load->view('admin/modal',$data);
	}

	public function sign_out(){
		$this->session->sess_destroy();
		redirect(base_url());
	}
}
