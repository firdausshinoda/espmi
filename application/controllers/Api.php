<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//header('Set-Cookie: cross-site-cookie=name; SameSite=None; Secure');

class Api extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('M_api');
	}

	public function api_inputKonsultasi(){
		$uploadPath = './assets/upload/dokumen/konsultasi/';
		$config['upload_path'] = $uploadPath;
		$config['allowed_types'] = 'pdf|doc|docx';
		$config['file_name'] = date('ymdHis');

		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		if($this->upload->do_upload('file')){
			$fileData = $this->upload->data();
			$nama_file	= $fileData['file_name'];
			$size_file	= $fileData['file_size'];

			$input['id_tb_admin'] = sess_get('id');
			$input['id_tb_unit'] = sess_get('id_unit');
			$input['nama_dokumen']	= post('judul');
			$input['deskripsi_dokumen']	= post('deskripsi');
			$input['file'] = $nama_file;
			$input['file_size']	= $size_file;
			$input['file_nama']	= post('nama_file');
			$input['file_type']	= $file_ext = pathinfo($nama_file,PATHINFO_EXTENSION);
			$input['bln_dokumen'] = post('bln_dokumen');
			$input['thn_dokumen'] = post('thn_dokumen');
			$input['jml_halaman'] = post('jml_halaman');
			$input['cdate'] = get_date();
			$id_konsultasi = db_input('tb_konsultasi',$input);
			if ($id_konsultasi){
				$input2['id_tb_unit'] = 11;
				$input2['id_tb_konsultasi'] = $id_konsultasi;
				$input2['cdate'] = get_date();
				db_input('tb_konsultasi_unit_terkait',$input2);
				setResponseJson("OK");
			} else {
				setResponseJson("ERROR",array('message'=>"Gagal mengunggah dokumen..."));
			}
		} else {
			setResponseJson("ERROR",array('message'=>"Gagal mengunggah dokumen!!!"));
		}
	}

	public function api_updateKonsultasi(){
		$date = get_date();
		$where['id_tb_konsultasi'] = post('id');
		$update['nama_dokumen']	= post('judul');
		$update['id_tb_jenis_dokumen']	= post('jenis_dokumen');
		$update['deskripsi_dokumen']	= post('deskripsi');
		$update['bln_dokumen'] = post('bln_dokumen');
		$update['thn_dokumen'] = post('thn_dokumen');
		$update['jml_halaman'] = post('jml_halaman');
		if (sess_get('espmi-superadmin')){
			$update['id_tb_jenis_dokumen'] = post('jenis_dokumen');
			if (empty(post('kode_tambahan'))){
				$update['id_tb_dokumen_kode'] = post('kode_no');
			} else {
				$input['jenis_dokumen'] = post('jenis_dokumen_tambahan');
				$input['nomor_dokumen'] = post('kode_tambahan');
				$input['perihal_dokumen'] = post('perihal_dokumen_tambahan');
				$update['id_tb_dokumen_kode'] = db_input('tb_dokumen_kode',$input);
			}
		}
		$update['mdate'] = $date;
		$stmt = db_update('tb_konsultasi',$where,$update);
		if ($stmt){
			$unit_baru = post('unit_baru');
			$unit_hapus = post('unit_hapus');
			for ($i=0; $i < count($unit_baru); $i++) {
				$input2['id_tb_unit'] = $unit_baru[$i];
				$input2['id_tb_konsultasi'] = post('id');
				$input2['cdate'] = $date;
				db_input('tb_konsultasi_unit_terkait',$input2);
			}
			for ($j=0; $j < count($unit_hapus); $j++) {
				$where2['id_tb_konsultasi_unit_terkait'] = $unit_baru[$j];
				$update2['del_flage'] = 0;
				$update2['ddate'] = $date;
				db_update('tb_konsultasi_unit_terkait',$where2,$update2);
			}
			setResponseJson("OK");
		} else {
			setResponseJson("ERROR",array('message'=>"Gagal Mengubah Konsultasi..."));
		}
	}

	public function api_inputDokumen(){
		$uploadPath = './assets/upload/dokumen/dokumen/';
		$config['upload_path'] = $uploadPath;
		$config['allowed_types'] = 'pdf';
		$config['file_name'] = date('ymdHis');

		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		if($this->upload->do_upload('file')){
			$fileData = $this->upload->data();
			$nama_file = $fileData['file_name'];
			$size_file = $fileData['file_size'];

			$input['id_tb_admin'] = sess_get('id');
			$input['id_tb_unit'] = post('unit_pembuat');
			$input['nama_dokumen']	= post('judul');
			$input['deskripsi_dokumen']	= post('deskripsi');
			$input['file'] = $nama_file;
			$input['file_size']	= $size_file;
			$input['file_nama']	= post('nama_file');
			$input['bln_dokumen'] = post('bln_dokumen');
			$input['thn_dokumen'] = post('thn_dokumen');
			$input['revisi'] = post('revisi');
			$input['id_tb_dokumen_kode'] = post('kode_no');
			$input['jml_halaman'] = post('jml_halaman');
			$input['id_tb_jenis_dokumen'] = post('jenis_dokumen');
			if (empty(post('kode_tambahan'))){
				$input['id_tb_dokumen_kode'] = post('kode_no');
			} else {
				$input2['id_tb_jenis_dokumen'] = post('jenis_dokumen_tambahan');
				$input2['nomor_dokumen'] = post('kode_tambahan');
				$input2['perihal_dokumen'] = post('perihal_dokumen_tambahan');
				$input2['cdate'] = get_date();
				$input['id_tb_dokumen_kode'] = db_input('tb_dokumen_kode',$input2);
			}
			$input['cdate'] = get_date();

			$id_dokumen = db_input('tb_dokumen',$input);
			if ($id_dokumen){
				if (sess_get('espmi-superadmin')){
					if (!empty(post('unit_terkait'))){
						foreach (post('unit_terkait') as $value) {
							$input4['id_tb_unit'] = $value;
							$input4['id_tb_dokumen'] = $id_dokumen;
							$input4['cdate'] = get_date();
							db_input('tb_dokumen_unit_terkait',$input4);
						}
					}
				}
				setResponseJson("OK");
			} else {
				setResponseJson("ERROR",array('message'=>"Gagal mengunggah dokumen..."));
			}
		} else {
			setResponseJson("ERROR",array('message'=>"Gagal mengunggah dokumen!!!"));
		}
	}

	public function api_updateDokumen(){
		$date = get_date();
		$file_baru = false;
		$where['id_tb_dokumen'] = post('id');
		$update['id_tb_unit'] = post('unit_pembuat');
		$update['nama_dokumen']	= post('judul');
		$update['deskripsi_dokumen']	= post('deskripsi');
		$update['bln_dokumen'] = post('bln_dokumen');
		$update['file_nama'] = post('nama_file');
		$update['file_size'] = post('size_file');
		$update['thn_dokumen'] = post('thn_dokumen');
		$update['jml_halaman'] = post('jml_halaman');
		$update['revisi'] = post('revisi');
		if (sess_get('espmi-superadmin')){
			$update['id_tb_jenis_dokumen'] = post('jenis_dokumen');
			if (empty(post('kode_tambahan'))){
				$update['id_tb_dokumen_kode'] = post('kode_no');
			} else {
				$input['id_tb_jenis_dokumen'] = post('jenis_dokumen_tambahan');
				$input['nomor_dokumen'] = post('kode_tambahan');
				$input['perihal_dokumen'] = post('perihal_dokumen_tambahan');
				$update['id_tb_dokumen_kode'] = db_input('tb_dokumen_kode',$input);
			}
		}

		$uploadPath = './assets/upload/dokumen/dokumen/';
		$config['upload_path'] = $uploadPath;
		$config['allowed_types'] = 'pdf';
		$config['file_name'] = date('ymdHis');

		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		if($this->upload->do_upload('file')) {
			$fileData = $this->upload->data();
			$nama_file = $fileData['file_name'];
			$size_file = $fileData['file_size'];

			$update['file'] = $nama_file;
			$update['file_size'] = $size_file;
			$file_baru = true;
		}

		$update['mdate'] = $date;
		$stmt = db_update('tb_dokumen',$where,$update);
		if ($stmt){
			$unit_baru = post('unit_baru');
			$unit_hapus = post('unit_hapus');
			for ($i=0; $i < count($unit_baru); $i++) {
				$input2['id_tb_unit'] = $unit_baru[$i];
				$input2['id_tb_dokumen'] = post('id');
				$input2['cdate'] = $date;
				db_input('tb_dokumen_unit_terkait',$input2);
			}
			for ($j=0; $j < count($unit_hapus); $j++) {
				$where2['id_tb_dokumen_unit_terkait'] = $unit_baru[$j];
				$update2['del_flage'] = 0;
				$update2['ddate'] = $date;
				db_update('tb_dokumen_unit_terkait',$where2,$update2);
			}
			if ($file_baru){
				$file_lama = post('file_lama');
				if (file_exists($uploadPath.$file_lama)) {
					unlink($uploadPath . $file_lama);
				}
			}
			setResponseJson("OK");
		} else {
			setResponseJson("ERROR",array('message'=>"Gagal Mengubah Konsultasi..."));
		}
	}

	public function api_updateDokumenRevisi(){
		$uploadPath = './assets/upload/dokumen/konsultasi/';
		$config['upload_path'] = $uploadPath;
		$config['allowed_types'] = 'pdf';
		$config['file_name'] = date('ymdHis');

		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		if($this->upload->do_upload('file')){
			$fileData = $this->upload->data();
			$nama_file = $fileData['file_name'];
			$size_file = $fileData['file_size'];

			$id = post('id');
			$where['id_tb_konsultasi'] = $id;
			$update['file'] = $nama_file;
			$update['revisi'] = (int)db_where('tb_konsultasi',array('id_tb_konsultasi'=>$id))->row()->revisi+1;
			$update['file_size'] = $size_file;
			$update['file_type']	= $file_ext = pathinfo($nama_file,PATHINFO_EXTENSION);
			$update['jml_halaman'] = post('jml_halaman');
			$update['mdate'] = get_date();
			if (db_update('tb_konsultasi',$where,$update)){
				$file_lama = post('file_lama');
				if (file_exists($uploadPath.$file_lama)) {
					unlink($uploadPath . $file_lama);
				}

				$unit_terkait = null;
				foreach (post('unit_terkait') as $value) {
					list($nama_unit, $id_unit) = explode('/', $value);
					if (empty($unit_terkait)){
						$unit_terkait = $nama_unit;
					} else {
						$unit_terkait .= ", ".$nama_unit;
					}
					$where2['id_tb_konsultasi'] = $id;
					$where2['id_tb_unit'] = $id_unit;
					$update2['stt_revisi_unit'] = "MENUNGGU";
					$update2['mdate'] = get_date();
					db_update('tb_konsultasi_unit_terkait',$where2,$update2);
				}
				$input['id_tb_konsultasi'] = $id;
				$input['id_tb_admin'] = sess_get('id');
				$input['unit_terkait'] = $unit_terkait;
				$input['keterangan'] = post('keterangan_revisi');
				$input['cdate'] = get_date();
				db_input('tb_konsultasi_revisi_admin',$input);
				setResponseJson("OK");
			} else {
				setResponseJson("ERROR",array('message'=>"Gagal mengunggah dokumen..."));
			}
		} else {
			setResponseJson("ERROR",array('message'=>"Gagal mengunggah dokumen!!!"));
		}

	}

	public function api_getUnitTerkait(){
		$where['tb_konsultasi_unit_terkait.id_tb_konsultasi'] = post('id');
		$where['tb_konsultasi_unit_terkait.del_flage'] = 1;
		$post = $this->input->post();
		$search         = $post['search']['value'];
		$length         = $post['length'];
		$start          = $post['start'];
		$order          = $post['order'];
		$stmt = $this->M_api->api_getUnitTerkait($length,$start,$search,$where,$order);
		$response = array('draw'    => $post['draw'],
			'recordsTotal'          => $this->M_api->api_getUnitTerkait(NULL,NULL,NULL,$where,$order)->num_rows(),
			'recordsFiltered'       => $this->M_api->api_getUnitTerkait(NULL,NULL,$search,$where,$order)->num_rows(),
			'data'                  => $stmt->result(),
			'csrfName'				=> $this->security->get_csrf_token_name(),
			'csrfHash'				=> $this->security->get_csrf_hash(),
			'search'                => $search);
		setResponseJson("OK",$response);
	}

	public function api_getRevisiUnit(){
		$where['id_tb_konsultasi_unit_terkait'] = post('id');
		$where['del_flage'] = 1;
		$response = array(
			'data'                  => db_where('tb_konsultasi_revisi_unit',$where)->result(),
			'csrfName'				=> $this->security->get_csrf_token_name(),
			'csrfHash'				=> $this->security->get_csrf_hash()
		);
		setResponseJson("OK",$response);
	}

	public function api_konfirmKonsultasi(){
		$input['id_tb_konsultasi_unit_terkait'] = post('id_konsultasi_unit_terkait');
		$input['id_tb_admin'] = sess_get('id');
		$input['keterangan'] = "ACC";
		$input['cdate'] = get_date();
		if (db_input('tb_konsultasi_revisi_unit',$input)){
			$where['id_tb_konsultasi'] = post('id_konsultasi');
			$update['mdate'] = get_date();
			if (sess_get('espmi-admin')){
				$where['id_tb_unit'] = sess_get('id_unit');
				$update['stt_revisi_unit'] = "ACC";
				db_update('tb_konsultasi_unit_terkait',$where,$update);
			} else {
				$update['stt_revisi_unit'] = "ACC";
				db_update('tb_konsultasi_unit_terkait',$where,$update);

				$where2['id_tb_konsultasi'] = post('id_konsultasi');
				$update2['stt_dokumen'] = "PUBLIS";
				$update2['publis_date'] = get_date();
				db_update('tb_konsultasi',$where2,$update2);
			}
			setResponseJson("OK");
		} else {
			setResponseJson("ERROR",array('message'=>"Token Salah"));
		}
	}

	public function api_inputRevisi(){
		$response = array('csrfName' => $this->security->get_csrf_token_name(), 'csrfHash' => $this->security->get_csrf_hash());
		$input['id_tb_konsultasi_unit_terkait'] = post('id_konsultasi_unit_terkait');
		$input['id_tb_admin'] = sess_get('id');
		$input['keterangan'] = post('keterangan',false);
		$input['cdate'] = get_date();
		if (db_input('tb_konsultasi_revisi_unit',$input)){
			$where['id_tb_konsultasi'] = post('id_konsultasi');
			$where['id_tb_unit'] = sess_get('id_unit');
			$update['stt_revisi_unit'] = "REVISI";
			$update['mdate'] = get_date();
			db_update('tb_konsultasi_unit_terkait',$where,$update);
			setResponseJson("OK",$response);
		} else {
			setResponseJson("ERROR",$response);
		}
	}

	public function api_getNoDok(){
		if (post('jenis_dokumen') != "all"){
			$where['tb_dokumen_kode.id_tb_jenis_dokumen'] = post('jenis_dokumen');
		}
		$where['tb_dokumen_kode.del_flage'] = 1;
		$post = $this->input->post();
		$search         = $post['search']['value'];
		$length         = $post['length'];
		$start          = $post['start'];
		$order          = $post['order'];
		$stmt = $this->M_api->api_getNoDok($length,$start,$search,$where,$order);
		$response = array('draw'    => $post['draw'],
			'recordsTotal'          => $this->M_api->api_getNoDok(NULL,NULL,NULL,$where,$order)->num_rows(),
			'recordsFiltered'       => $this->M_api->api_getNoDok(NULL,NULL,$search,$where,$order)->num_rows(),
			'data'                  => $stmt->result(),
			'csrfName'				=> $this->security->get_csrf_token_name(),
			'csrfHash'				=> $this->security->get_csrf_hash(),
			'search'                => $search);
		setResponseJson("OK",$response);
	}

	public function api_inputNoDok(){
		$input['id_tb_jenis_dokumen'] = post('jenis_dokumen');
		$input['nomor_dokumen'] = post('nomor_dokumen');
		$input['perihal_dokumen'] = post('perihal_dokumen');
		$input['cdate'] = get_date();
		if (db_input('tb_dokumen_kode',$input)){
			setResponseJson("OK");
		} else {
			setResponseJson("ERROR");
		}
	}

	public function api_updateNoDok(){
		$where['id_tb_dokumen_kode'] = post('id');
		$update['id_tb_jenis_dokumen'] = post('jenis_dokumen');
		$update['nomor_dokumen'] = post('nomor_dokumen');
		$update['perihal_dokumen'] = post('perihal_dokumen');
		$update['mdate'] = get_date();
		if (db_update('tb_dokumen_kode',$where,$update)){
			setResponseJson("OK");
		} else {
			setResponseJson("ERROR");
		}
	}

	public function api_getDafUnit(){
		$where['del_flage'] = 1;
		$post = $this->input->post();
		$search         = $post['search']['value'];
		$length         = $post['length'];
		$start          = $post['start'];
		$order          = $post['order'];
		$stmt = $this->M_api->api_getDafUnit($length,$start,$search,$where,$order);
		$response = array('draw'    => $post['draw'],
			'recordsTotal'          => $this->M_api->api_getDafUnit(NULL,NULL,NULL,$where,$order)->num_rows(),
			'recordsFiltered'       => $this->M_api->api_getDafUnit(NULL,NULL,$search,$where,$order)->num_rows(),
			'data'                  => $stmt->result(),
			'csrfName'				=> $this->security->get_csrf_token_name(),
			'csrfHash'				=> $this->security->get_csrf_hash(),
			'search'                => $search);
		setResponseJson("OK",$response);
	}

	public function api_inputDafUnit(){
		$input['nama_unit'] = post('nama_unit');
		$input['keterangan'] = post('keterangan');
		$input['cdate'] = get_date();
		if (db_input('tb_unit',$input)){
			setResponseJson("OK");
		} else {
			setResponseJson("ERROR");
		}
	}

	public function api_updateDafUnit(){
		$where['id_tb_unit'] = post('id');
		$update['nama_unit'] = post('nama_unit');
		$update['keterangan'] = post('keterangan');
		$update['mdate'] = get_date();
		if (db_update('tb_unit',$where,$update)){
			setResponseJson("OK");
		} else {
			setResponseJson("ERROR");
		}
	}

	public function api_detailDafUnit(){
		if (get('token')==get_token()){
			$stmt = db_where('tb_unit',array('id_tb_unit'=>get('id')));
			if ($stmt){
				setResponseJson("OK",$stmt->row());
			} else {
				setResponseJson("ERROR",array('message'=>"Gagal Mengambil Data!"));
			}
		} else {
			setResponseJson("ERROR",array('message'=>"Token Salah"));
		}
	}

	public function api_getSuperadmin(){
		$where['tb_admin.del_flage'] = 1;
		$where['tb_admin.jenis_admin'] = "SUPERADMIN";
		$post = $this->input->post();
		$search         = $post['search']['value'];
		$length         = $post['length'];
		$start          = $post['start'];
		$order          = $post['order'];
		$stmt = $this->M_api->api_getSuperadmin($length,$start,$search,$where,$order);
		$response = array('draw'    => $post['draw'],
			'recordsTotal'          => $this->M_api->api_getSuperadmin(NULL,NULL,NULL,$where,$order)->num_rows(),
			'recordsFiltered'       => $this->M_api->api_getSuperadmin(NULL,NULL,$search,$where,$order)->num_rows(),
			'data'                  => $stmt->result(),
			'csrfName' => $this->security->get_csrf_token_name(),
			'csrfHash' => $this->security->get_csrf_hash(),
			'search'                => $search);
		setResponseJson("OK",$response);
	}

	public function api_inputSuperadmin(){
		$where['nipy'] = post('nipy');
		$where['del_flage'] = 1;
		$stmt = db_where('tb_admin',$where);
		$response = array('csrfName' => $this->security->get_csrf_token_name(), 'csrfHash' => $this->security->get_csrf_hash());
		if ($stmt->num_rows() == 0){
			$input['nama_admin'] = post('nama_admin');
			$input['jenis_admin'] = "SUPERADMIN";
			$input['nipy'] = post('nipy');
			$input['password'] = md5(post('password'));
			$input['id_tb_unit'] = post('unit');
			$input['cdate'] = get_date();
			if (db_input('tb_admin',$input)){
				setResponseJson("OK",$response);
			} else {
				setResponseJson("ERROR",$response);
			}
		} else {
			setResponseJson("EXIST",$response);
		}
	}

	public function api_detailSuperadmin(){
		$stmt = $this->M_api->api_getAdmin(-1,NULL,"",array('tb_admin.id_tb_admin'=>get('id')),"DESC");
		if ($stmt){
			setResponseJson("OK",$stmt->row());
		} else {
			setResponseJson("ERROR",array('message'=>"Gagal Mengambil Data!"));
		}
	}

	public function api_updateSuperadmin(){
		$where_chek['nipy'] = post('nipy');
		$where_chek['id_tb_admin !='] = post('id');
		$stmt = db_where('tb_admin',$where_chek);
		$response = array('csrfName' => $this->security->get_csrf_token_name(), 'csrfHash' => $this->security->get_csrf_hash());
		if ($stmt->num_rows() == 0){
			$where['id_tb_admin'] = post('id');
			$update['nama_admin'] = post('nama_admin');
			$update['nipy'] = post('nipy');
			if (!empty(post('password'))){
				$update['password'] = md5(post('password'));
			}
			$update['id_tb_unit'] = post('unit');
			$update['jenis_unit'] = post('jenis_unit');
			$update['mdate'] = get_date();
			if (db_update('tb_admin',$where,$update)){
				setResponseJson("OK",$response);
			} else {
				setResponseJson("ERROR",$response);
			}
		} else {
			setResponseJson("EXIST",$response);
		}
	}

	public function api_getAdmin(){
		$where['tb_admin.del_flage'] = 1;
		$where['tb_admin.jenis_admin'] = "ADMIN";
		$post = $this->input->post();
		$search         = $post['search']['value'];
		$length         = $post['length'];
		$start          = $post['start'];
		$order          = $post['order'];
		$stmt = $this->M_api->api_getAdmin($length,$start,$search,$where,$order);
		$response = array('draw'    => $post['draw'],
			'recordsTotal'          => $this->M_api->api_getAdmin(NULL,NULL,NULL,$where,$order)->num_rows(),
			'recordsFiltered'       => $this->M_api->api_getAdmin(NULL,NULL,$search,$where,$order)->num_rows(),
			'data'                  => $stmt->result(),
			'csrfName' => $this->security->get_csrf_token_name(),
			'csrfHash' => $this->security->get_csrf_hash(),
			'search'                => $search);
		setResponseJson("OK",$response);
	}

	public function api_inputAdmin(){
		$where['nipy'] = post('nipy');
		$where['del_flage'] = 1;
		$response = array('csrfName' => $this->security->get_csrf_token_name(), 'csrfHash' => $this->security->get_csrf_hash());
		$stmt = db_where('tb_admin',$where);
		if ($stmt->num_rows() == 0){
			$input['nama_admin'] = post('nama_admin');
			$input['nipy'] = post('nipy');
			$input['password'] = md5(post('password'));
			$input['id_tb_unit'] = post('unit');
			$input['jenis_unit'] = post('jenis_unit');
			$input['cdate'] = get_date();
			if (db_input('tb_admin',$input)){
				setResponseJson("OK",$response);
			} else {
				setResponseJson("ERROR",$response);
			}
		} else {
			setResponseJson("EXIST",$response);
		}
	}

	public function api_detailPengguna(){
		$stmt = $this->M_api->api_getAdmin(-1,NULL,"",array('tb_admin.id_tb_admin'=>get('id')),"DESC");
		if ($stmt){
			setResponseJson("OK",$stmt->row());
		} else {
			setResponseJson("ERROR",array('message'=>"Gagal Mengambil Data!"));
		}
	}

	public function api_updateAdmin(){
		$where_chek['nipy'] = post('nipy');
		$where_chek['id_tb_admin !='] = post('id');
		$stmt = db_where('tb_admin',$where_chek);
		$response = array('csrfName' => $this->security->get_csrf_token_name(), 'csrfHash' => $this->security->get_csrf_hash());
		if ($stmt->num_rows() == 0){
			$where['id_tb_admin'] = post('id');
			$update['nama_admin'] = post('nama_admin');
			$update['nipy'] = post('nipy');
			if (!empty(post('password'))){
				$update['password'] = md5(post('password'));
			}
			$update['id_tb_unit'] = post('unit');
			$update['jenis_unit'] = post('jenis_unit');
			$update['mdate'] = get_date();
			if (db_update('tb_admin',$where,$update)){
				setResponseJson("OK",$response);
			} else {
				setResponseJson("ERROR",$response);
			}
		} else {
			setResponseJson("EXIST",$response);
		}
	}

	public function api_getUser(){
		$where['del_flage'] = 1;
		$post = $this->input->post();
		$search         = $post['search']['value'];
		$length         = $post['length'];
		$start          = $post['start'];
		$order          = $post['order'];
		$stmt = $this->M_api->api_getUser($length,$start,$search,$where,$order);
		$response = array('draw'    => $post['draw'],
			'recordsTotal'          => $this->M_api->api_getUser(NULL,NULL,NULL,$where,$order)->num_rows(),
			'recordsFiltered'       => $this->M_api->api_getUser(NULL,NULL,$search,$where,$order)->num_rows(),
			'data'                  => $stmt->result(),
			'csrfName'				=> $this->security->get_csrf_token_name(),
			'csrfHash'				=> $this->security->get_csrf_hash(),
			'search'                => $search);
		setResponseJson("OK",$response);
	}

	public function api_inputUser(){
		$where['nipy'] = post('nipy');
		$where['del_flage'] = 1;
		$response = array('csrfName' => $this->security->get_csrf_token_name(), 'csrfHash' => $this->security->get_csrf_hash());
		$stmt = db_where('tb_user',$where);
		if ($stmt->num_rows() == 0){
			$input['nama_user'] = post('nama');
			$input['nipy'] = post('nipy');
			$input['password'] = md5(post('password'));
			$input['cdate'] = get_date();
			if (db_input('tb_user',$input)){
				setResponseJson("OK",$response);
			} else {
				setResponseJson("ERROR",$response);
			}
		} else {
			setResponseJson("EXIST",$response);
		}
	}

	public function api_detailUser(){
		$stmt = $this->M_api->api_getUser(-1,NULL,"",array('id_tb_user'=>get('id')),"DESC");
		if ($stmt){
			setResponseJson("OK",$stmt->row());
		} else {
			setResponseJson("ERROR",array('message'=>"Gagal Mengambil Data!"));
		}
	}

	public function api_updateUser(){
		$where_chek['nipy'] = post('nipy');
		$where_chek['id_tb_user !='] = post('id');
		$stmt = db_where('tb_user',$where_chek);
		$response = array('csrfName' => $this->security->get_csrf_token_name(), 'csrfHash' => $this->security->get_csrf_hash());
		if ($stmt->num_rows() == 0){
			$where['id_tb_user'] = post('id');
			$update['nama_user'] = post('nama_user');
			$update['nipy'] = post('nipy');
			if (!empty(post('password'))){
				$update['password'] = md5(post('password'));
			}
			$update['mdate'] = get_date();
			if (db_update('tb_user',$where,$update)){
				setResponseJson("OK",$response);
			} else {
				setResponseJson("ERROR",$response);
			}
		} else {
			setResponseJson("EXIST",$response);
		}
	}

	public function api_getJenisDokumen(){
		$post = $this->input->post();
		$search         = $post['search']['value'];
		$length         = $post['length'];
		$start          = $post['start'];
		$order          = $post['order'];
		$stmt = $this->M_api->api_getJenisDokumen($length,$start,$search,$order);
		$response = array('draw'    => $post['draw'],
			'recordsTotal'          => $this->M_api->api_getJenisDokumen(NULL,NULL,NULL,$order)->num_rows(),
			'recordsFiltered'       => $this->M_api->api_getJenisDokumen(NULL,NULL,$search,$order)->num_rows(),
			'data'                  => $stmt->result(),
			'csrfName' => $this->security->get_csrf_token_name(),
			'csrfHash' => $this->security->get_csrf_hash(),
			'search'                => $search);
		setResponseJson("OK",$response);
	}

	public function api_inputJenisDokumen(){
		$input['jenis_dokumen'] = post('jenis_dokumen');
		$input['keterangan'] = post('keterangan');
		$input['tipe_dokumen'] = "DOKUMEN INSTITUSI";
		$input['cdate'] = get_date();
		if (db_input('tb_jenis_dokumen',$input)){
			setResponseJson("OK");
		} else {
			setResponseJson("ERROR");
		}
	}

	public function api_updateJenisDokumen(){
		$where['id_tb_jenis_dokumen'] = post('id');
		$update['jenis_dokumen'] = post('jenis_dokumen');
		$update['keterangan'] = post('keterangan');
		$update['mdate'] = get_date();
		if (db_update('tb_jenis_dokumen',$where,$update)){
			setResponseJson("OK");
		} else {
			setResponseJson("ERROR");
		}
	}

	public function api_getLaporan(){
		$page = get('page');
		if ($page=="list-dokumen"){
			$post = $this->input->post();
			$where['tb_dokumen.del_flage']		= 1;
			if (post('jenis_dokumen') != "Semua"){
				$where['tb_dokumen.id_tb_jenis_dokumen']	= post('jenis_dokumen');
			}
			$length         = $post['length'];
			$start          = $post['start'];
			$order          = $post['order'];
			$stmt = $this->M_api->api_getLaporanDokumen($length,$start,$where,$order);
			$response = array('draw'    => $post['draw'],
				'recordsTotal'          => $this->M_api->api_getLaporanDokumen(NULL,NULL,$where,$order)->num_rows(),
				'recordsFiltered'       => $this->M_api->api_getLaporanDokumen(NULL,NULL,$where,$order)->num_rows(),
				'data'                  => $stmt->result(),
				'csrfName'				=> $this->security->get_csrf_token_name(),
				'csrfHash'				=> $this->security->get_csrf_hash(),
				'search'                => NULL);
		} else if ($page=="list-konsultasi"){
			$post = $this->input->post();
			$where['tb_konsultasi.del_flage']		= 1;
			if (post('jenis_dokumen') != "Semua"){
				$where['tb_konsultasi.id_tb_jenis_dokumen']	= post('jenis_dokumen');
			}
			$length         = $post['length'];
			$start          = $post['start'];
			$order          = $post['order'];
			$stmt = $this->M_api->api_getLaporanKonsultasi($length,$start,$where,$order);
			$response = array('draw'    => $post['draw'],
				'recordsTotal'          => $this->M_api->api_getLaporanKonsultasi(NULL,NULL,$where,$order)->num_rows(),
				'recordsFiltered'       => $this->M_api->api_getLaporanKonsultasi(NULL,NULL,$where,$order)->num_rows(),
				'data'                  => $stmt->result(),
				'csrfName'				=> $this->security->get_csrf_token_name(),
				'csrfHash'				=> $this->security->get_csrf_hash(),
				'search'                => NULL);
		} else if ($page=="list-jendok"){
			$post = $this->input->post();
			$where['del_flage']		= 1;
			$length         = $post['length'];
			$start          = $post['start'];
			$order          = $post['order'];
			$stmt = $this->M_api->api_getLaporanJendok($length,$start,$where,$order);
			$response = array('draw'    => $post['draw'],
				'recordsTotal'          => $this->M_api->api_getLaporanJendok(NULL,NULL,$where,$order)->num_rows(),
				'recordsFiltered'       => $this->M_api->api_getLaporanJendok(NULL,NULL,$where,$order)->num_rows(),
				'data'                  => $stmt->result(),
				'csrfName'				=> $this->security->get_csrf_token_name(),
				'csrfHash'				=> $this->security->get_csrf_hash(),
				'search'                => NULL);
		} else if ($page=="list-nodok"){
			$post = $this->input->post();
			$where['tb_dokumen_kode.del_flage']		= 1;
			if (post('jenis_dokumen') != "Semua"){
				$where['tb_dokumen_kode.id_tb_jenis_dokumen']	= post('jenis_dokumen');
			}
			$length         = $post['length'];
			$start          = $post['start'];
			$order          = $post['order'];
			$stmt = $this->M_api->api_getLaporanNodok($length,$start,$where,$order);
			$response = array('draw'    => $post['draw'],
				'recordsTotal'          => $this->M_api->api_getLaporanNodok(NULL,NULL,$where,$order)->num_rows(),
				'recordsFiltered'       => $this->M_api->api_getLaporanNodok(NULL,NULL,$where,$order)->num_rows(),
				'data'                  => $stmt->result(),
				'csrfName'				=> $this->security->get_csrf_token_name(),
				'csrfHash'				=> $this->security->get_csrf_hash(),
				'search'                => NULL);
		} else if ($page=="list-unit"){
			$post = $this->input->post();
			$where['del_flage']		= 1;
			$length         = $post['length'];
			$start          = $post['start'];
			$order          = $post['order'];
			$stmt = $this->M_api->api_getLaporanUnit($length,$start,$where,$order);
			$response = array('draw'    => $post['draw'],
				'recordsTotal'          => $this->M_api->api_getLaporanUnit(NULL,NULL,$where,$order)->num_rows(),
				'recordsFiltered'       => $this->M_api->api_getLaporanUnit(NULL,NULL,$where,$order)->num_rows(),
				'data'                  => $stmt->result(),
				'csrfName'				=> $this->security->get_csrf_token_name(),
				'csrfHash'				=> $this->security->get_csrf_hash(),
				'search'                => NULL);
		} else if ($page=="list-user-unit"){
			$post = $this->input->post();
			$where['tb_admin.del_flage']		= 1;
			$where['tb_admin.jenis_admin'] 	= "ADMIN";
			if (post('jenis_unit') != "Semua"){
				$where['tb_admin.jenis_unit'] = post('jenis_unit');
			}
			$length         = $post['length'];
			$start          = $post['start'];
			$order          = $post['order'];
			$stmt = $this->M_api->api_getLaporanAdmin($length,$start,$where,$order);
			$response = array('draw'    => $post['draw'],
				'recordsTotal'          => $this->M_api->api_getLaporanAdmin(NULL,NULL,$where,$order)->num_rows(),
				'recordsFiltered'       => $this->M_api->api_getLaporanAdmin(NULL,NULL,$where,$order)->num_rows(),
				'data'                  => $stmt->result(),
				'csrfName'				=> $this->security->get_csrf_token_name(),
				'csrfHash'				=> $this->security->get_csrf_hash(),
				'search'                => NULL);
		} else if ($page=="list-user-view"){
			$post = $this->input->post();
			$where['del_flage']		= 1;
			$length         = $post['length'];
			$start          = $post['start'];
			$order          = $post['order'];
			$stmt = $this->M_api->api_getLaporanPengguna($length,$start,$where,$order);
			$response = array('draw'    => $post['draw'],
				'recordsTotal'          => $this->M_api->api_getLaporanPengguna(NULL,NULL,$where,$order)->num_rows(),
				'recordsFiltered'       => $this->M_api->api_getLaporanPengguna(NULL,NULL,$where,$order)->num_rows(),
				'data'                  => $stmt->result(),
				'csrfName'				=> $this->security->get_csrf_token_name(),
				'csrfHash'				=> $this->security->get_csrf_hash(),
				'search'                => NULL);
		}
		setResponseJson("OK",$response);
	}

	public function api_profilImage(){
		$stmt=null;
		$imageName=null;
		$table=null;
		$update=null;
		$where=null;

		$data = $_POST['image'];
		list($type, $data) = explode(';', $data);
		list(, $data)      = explode(',', $data);
		$data = base64_decode($data);
		$imageName = date('YmdHis').'.png';
		if (sess_get('espmi-superadmin') || sess_get('espmi-admin')){
			$where['id_tb_admin'] = sess_get('id');
			$update['foto_admin'] = $imageName;
			$update['mdate'] = get_date();
			$tb = "tb_admin";
		} elseif (sess_get('espmi-user')){
			$where['id_tb_user'] = sess_get('id');
			$update['foto_user'] = $imageName;
			$update['mdate'] = get_date();
			$tb = "tb_user";
		}

		$response = array('csrfName' => $this->security->get_csrf_token_name(), 'csrfHash' => $this->security->get_csrf_hash());
		$stmt = file_put_contents('assets/upload/img/profil/'.$imageName, $data);
		if ($stmt){
			db_update($tb,$where,$update);
			sess_set(array('foto'=>$imageName));
			setResponseJson("OK",$response);
		} else {
			setResponseJson("ERROR",$response);
		}
	}

	public function api_profilUpdate(){
		$imageName=null;
		$table=null;
		$update=null;
		$where=null;
		if (sess_get('espmi-superadmin') || sess_get('espmi-admin')){
			$where_check['nipy'] = post('nipy');
			$where_check['id_tb_admin !='] = sess_get('id');
			$where['id_tb_admin'] = sess_get('id');
			$update['nama_admin'] = post('nama');
			$update['nipy'] = post('nipy');
			$update['mdate'] = get_date();
			$tb = "tb_admin";
		} elseif (sess_get('espmi-user')){
			$where_check['nipy'] = post('nipy');
			$where_check['id_tb_user !='] = sess_get('id');
			$where['id_tb_user'] = sess_get('id');
			$update['nama_user'] = post('nama');
			$update['nipy'] = post('nipy');
			$update['mdate'] = get_date();
			$tb = "tb_user";
		}

		$response = array('csrfName' => $this->security->get_csrf_token_name(), 'csrfHash' => $this->security->get_csrf_hash());
		$check = db_where($tb,$where_check);
		if ($check->num_rows() ==0 ){
			if (db_update($tb,$where,$update)){
				sess_set(array('nama'=>post('nama'),'nipy'=>post('nipy')));
				setResponseJson("OK",$response);
			} else {
				setResponseJson("ERROR",$response);
			}
		} else {
			setResponseJson("EXIST",$response);
		}
	}

	public function api_profilPassword(){
		$imageName=null;
		$table=null;
		$update=null;
		$where=null;
		$response = array('csrfName' => $this->security->get_csrf_token_name(), 'csrfHash' => $this->security->get_csrf_hash());
		if (sess_get('espmi-superadmin') || sess_get('espmi-admin')){
			$where['id_tb_admin'] = sess_get('id');
			$ck = db_where('tb_admin',$where)->row();
			if ($ck->password != md5(post('password_lama'))){
				setResponseJson("NOT-SAME",$response);
				return false;
			}
			$update['password'] = md5(post('password_baru'));
			$update['mdate'] = get_date();
			$tb = "tb_admin";
		} elseif (sess_get('espmi-user')){
			$where['id_tb_user'] = sess_get('id');
			$ck = db_where('tb_user',$where)->row();
			if ($ck->password != md5(post('password_lama'))){
				setResponseJson("NOT-SAME",$response);
				return false;
			}
			$update['password'] = md5(post('password_baru'));
			$update['mdate'] = get_date();
			$tb = "tb_user";
		}


		if (db_update($tb,$where,$update)){
			setResponseJson("OK",$response);
		} else {
			setResponseJson("ERROR",$response);
		}
	}

	public function api_deleteData(){
		$page = post('page');
		$id = post('id');
		$str1 = post('str1');
		$stmt = false;
		$update['del_flage'] = 0;
		$update['ddate'] = get_date();
		if ($page=="nodok"){
			$where['id_tb_dokumen_kode'] = $id;
			$stmt = db_update('tb_dokumen_kode',$where,$update);
		} elseif ($page=="dafunit"){
			$where['id_tb_unit'] = $id;
			$stmt = db_update('tb_unit',$where,$update);
		} elseif ($page=="pengguna-admin"){
			$where['id_tb_admin'] = $id;
			$stmt = db_update('tb_admin',$where,$update);
		} elseif ($page=="pengguna-user"){
			$where['id_tb_user'] = $id;
			$stmt = db_update('tb_user',$where,$update);
		} elseif ($page=="jendok"){
			$where['id_tb_jenis_dokumen'] = $id;
			$stmt = db_update('tb_jenis_dokumen',$where,$update);
		} elseif ($page=="hapus-file-konsultasi"){
			$file = $str1;
			$file_lama = $str1;
			$uploadPath = "./assets/dokumen/konsultasi/";
			if (file_exists($uploadPath.$file_lama)) {
				unlink($uploadPath . $file_lama);
			}
		} elseif ($page=="hapus-dokumen"){
			$where['id_tb_dokumen'] = $id;
			$stmt = db_update('tb_dokumen',$where,$update);
		} elseif ($page=="hapus-konsultasi"){
			$where['id_tb_konsultasi'] = $id;
			$stmt = db_update('tb_konsultasi',$where,$update);
		}

		if ($stmt){
			$response = array(
				'csrfName' => $this->security->get_csrf_token_name(),
				'csrfHash' => $this->security->get_csrf_hash()
			);
			setResponseJson("OK",$response);
		} else {
			setResponseJson("ERROR",array('message'=>"Gagal menghapus data...!!!"));
		}
	}

	public function notificationView(){
		$offset = get('offset');
		$search = get('search');
		if (sess_get('espmi-superadmin')){
			$data['data'] = $this->M_api->notificationView($offset,$search,"superadmin");
			$data['ttl'] = $this->M_api->notificationView(NULL,$search,"superadmin")->num_rows();
		} else {
			$data['data'] = $this->M_api->notificationView($offset,$search,"admin");
			$data['ttl'] = $this->M_api->notificationView(NULL,$search,"admin")->num_rows();
		}

		if (sess_get('espmi-admin')){
			$this->load->view('admin/notification/notification-view',$data);
		} elseif (sess_get('espmi-superadmin')){
			$this->load->view('superadmin/notification/notification-view',$data);
		}
	}

	public function dokumenView(){
		$type = get('type');
		$kategori = get('kategori');
		$page = get('page');
		$offset = get('offset');
		$search = get('search');
//		if (!empty($type)){
//			if ($type=="standar"){
//				$where['tb_dokumen.jenis_dokumen'] = "Standar SPMI";
//			} elseif ($type=="manual-mutu-penetapan"){
//				$where['tb_dokumen.jenis_dokumen'] = "Manual Mutu Penetapan";
//			} elseif ($type=="manual-mutu-pelaksanaan"){
//				$where['tb_dokumen.jenis_dokumen'] = "Manual Mutu Pelaksanaan";
//			} elseif ($type=="manual-mutu-evaluasi"){
//				$where['tb_dokumen.jenis_dokumen'] = "Manual Mutu Evaluasi";
//			} elseif ($type=="manual-mutu-pengendalian"){
//				$where['tb_dokumen.jenis_dokumen'] = "Manual Mutu Pengendalian";
//			} elseif ($type=="manual-mutu-peningkatan"){
//				$where['tb_dokumen.jenis_dokumen'] = "Manual Mutu Peningkatan";
//			} elseif ($type=="formulir"){
//				$where['tb_dokumen.jenis_dokumen'] = "Formulir";
//			} elseif ($type=="kebijakan"){
//				$where['tb_dokumen.jenis_dokumen'] = "Kebijakan";
//			}
//		} else {
//			$kategori = get('kategori');
//			if (!empty($kategori) && $kategori != "sp_all"){
//				if ($kategori=="sp_standar"){
//					$kategori = "Standar SPMI";
//				} elseif ($kategori=="sp_manual_penetapan"){
//					$kategori = "Manual Mutu Penetapan";
//				} elseif ($kategori=="sp_manual_pelaksanaan"){
//					$kategori = "Manual Mutu Pelaksanaan";
//				} elseif ($kategori=="sp_manual_evaluasi"){
//					$kategori = "Manual Mutu Evaluasi";
//				} elseif ($kategori=="sp_manual_pengendalian"){
//					$kategori = "Manual Mutu Pengendalian";
//				} elseif ($kategori=="sp_manual_peningkatan"){
//					$kategori = "Manual Mutu Peningkatan";
//				} elseif ($kategori=="sp_formulir"){
//					$kategori = "Formulir";
//				} elseif ($kategori=="sp_kebijakan"){
//					$kategori = "Kebijakan";
//				}
//				$where['tb_dokumen.jenis_dokumen'] = $kategori;
//			} elseif ($kategori=="kebijakan"){
//				$where['tb_dokumen.jenis_dokumen'] = "Kebijakan";
//			}
//		}
		if (empty($type)) {
			if ($kategori!="0"){
				$where['tb_jenis_dokumen.id_tb_jenis_dokumen'] = $kategori;
			}
		} else if ($type=="standar-spmi"){
			$where['tb_jenis_dokumen.id_tb_jenis_dokumen'] = 1;
		} else if ($type=="manual-mutu-penetapan"){
			$where['tb_jenis_dokumen.id_tb_jenis_dokumen'] = 2;
		} else if ($type=="manual-mutu-pelaksanaan"){
			$where['tb_jenis_dokumen.id_tb_jenis_dokumen'] = 3;
		} else if ($type=="manual-mutu-evaluasi"){
			$where['tb_jenis_dokumen.id_tb_jenis_dokumen'] = 4;
		} else if ($type=="manual-mutu-pengendalian"){
			$where['tb_jenis_dokumen.id_tb_jenis_dokumen'] = 5;
		} else if ($type=="manual-mutu-peningkatan"){
			$where['tb_jenis_dokumen.id_tb_jenis_dokumen'] = 6;
		} else if ($type=="formulir"){
			$where['tb_jenis_dokumen.id_tb_jenis_dokumen'] = 7;
		} else if ($type=="kebijakan"){
			$where['tb_jenis_dokumen.id_tb_jenis_dokumen'] = 8;
		} else if ($type=="dok-institusi"){
			if ($kategori=="0"){
				$where['tb_jenis_dokumen.tipe_dokumen'] = "DOKUMEN INSTITUSI";
			} else {
				$where['tb_jenis_dokumen.id_tb_jenis_dokumen'] = $kategori;
			}
		}

		if (sess_get('espmi-admin')){
			if (!empty($type)){
				$where['tb_dokumen.id_tb_unit'] = sess_get('id_unit');
			}
		}
		$where['tb_dokumen.del_flage'] = 1;
		$data['data'] = $this->M_api->dokumenView($where,$offset,$search);
		$data['ttl'] =  $this->M_api->dokumenView($where,-1,$search)->num_rows();
		$data['type'] = $type;
		if (sess_get('espmi-admin')){
			$this->load->view('admin/viewDokumen',$data);
		} elseif (sess_get('espmi-superadmin')){
			$this->load->view('superadmin/viewDokumen',$data);
		} elseif (sess_get('espmi-user')){
			$this->load->view('user/dashboard/viewDokumen',$data);
		}
	}

	public function konsultasiView(){
		$offset = get('offset');
		$search = get('search');

		$where['tb_konsultasi.del_flage'] = 1;
		if (sess_get('espmi-admin')){
			$where['tb_konsultasi.id_tb_admin'] = sess_get('id');
		}
		$data['data'] = $this->M_api->konsultasiView($where,$offset,$search);
		$data['ttl'] =  $this->M_api->konsultasiView($where,-1,$search)->num_rows();
		if (sess_get('espmi-admin')){
			$this->load->view('admin/viewKonsultasi',$data);
		} elseif (sess_get('espmi-superadmin')){
			$this->load->view('superadmin/viewKonsultasi',$data);
		}
	}

	public function selectKode(){
		$where['tb_dokumen_kode.del_flage'] = 1;
		$where['tb_dokumen_kode.id_tb_jenis_dokumen'] = post('id_jenis');
		$page = post('page');
		$resultCount = 5;
		$offset = ($page - 1) * $resultCount;
		$stmt = $this->M_api->selectKode($resultCount,$offset,post('search'),$where)->result();
		$count = $this->M_api->selectKode(NULL,NULL,post('search'),$where)->num_rows();
		$endCount = $offset + $resultCount;
		$morePages = $endCount < $count;
		setJSON(array('results'=>$stmt,'morePages'=>$morePages,
			'csrfName' => $this->security->get_csrf_token_name(),
			'csrfHash' => $this->security->get_csrf_hash()
		));
	}

	public function selectUnit(){
		$page = post('page');
		$resultCount = 5;
		$offset = ($page - 1) * $resultCount;
		$stmt = $this->M_api->selectUnit($resultCount,$offset,post('search'))->result();
		$count = $this->M_api->selectUnit(NULL,NULL,post('search'))->num_rows();
		$endCount = $offset + $resultCount;
		$morePages = $endCount < $count;
		setJSON(array('results'=>$stmt,'morePages'=>$morePages,
			'csrfName' => $this->security->get_csrf_token_name(),
			'csrfHash' => $this->security->get_csrf_hash()
		));
	}

	public function selectJenisDokumen(){
		$page = post('page');
		$type = post('type');
		$resultCount = 5;
		$offset = ($page - 1) * $resultCount;
		if (!empty($type)){
			$where['tipe_dokumen'] = $type;
		}
		$where['del_flage'] = 1;
		$stmt = $this->M_api->selectJenisDokumen($resultCount,$offset,post('search'),$where)->result();
		$count = $this->M_api->selectJenisDokumen(NULL,NULL,post('search'),$where)->num_rows();
		$endCount = $offset + $resultCount;
		$morePages = $endCount < $count;
		setJSON(array('results'=>$stmt,'morePages'=>$morePages,
			'csrfName' => $this->security->get_csrf_token_name(),
			'csrfHash' => $this->security->get_csrf_hash()
		));
	}
}
