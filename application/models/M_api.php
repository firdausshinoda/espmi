<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_api extends CI_Model
{

	public function konsultasiView($where,$offset,$search){
		if (!empty($search)){
			$this->db->group_start()
				->like("LOWER(tb_konsultasi.nama_dokumen)", strtolower($search))
				->or_like("LOWER(tb_konsultasi_kode.nomor_dokumen)", strtolower($search))
				->or_like("LOWER(tb_konsultasi.deskripsi_dokumen)", strtolower($search))
				->or_like("LOWER(tb_konsultasi.bln_dokumen)", strtolower($search))
				->or_like("LOWER(tb_konsultasi.thn_dokumen)", strtolower($search))
				->or_like("LOWER(tb_konsultasi.jml_halaman)", strtolower($search))
				->or_like("LOWER(tb_konsultasi.stt_dokumen)", strtolower($search))
				->or_like("LOWER(tb_jenis_dokumen.jenis_dokumen)", strtolower($search))
				->or_like("LOWER(tb_unit.nama_unit)", strtolower($search))
				->group_end();
		}
		if ($offset != -1){
			$this->db->limit(6,$offset);
		}
		return $this->db->select('tb_konsultasi.*, tb_dokumen_kode.nomor_dokumen, tb_jenis_dokumen.jenis_dokumen,
					tb_admin.id_tb_unit, tb_admin.nama_admin, tb_admin.nipy, tb_unit.nama_unit,')
			->join('tb_dokumen_kode','tb_dokumen_kode.id_tb_dokumen_kode = tb_konsultasi.id_tb_dokumen_kode','LEFT')
			->join('tb_jenis_dokumen','tb_jenis_dokumen.id_tb_jenis_dokumen = tb_konsultasi.id_tb_jenis_dokumen','LEFT')
			->join('tb_admin','tb_admin.id_tb_admin = tb_konsultasi.id_tb_admin')
			->join('tb_unit','tb_unit.id_tb_unit = tb_admin.id_tb_unit')
			->order_by('tb_konsultasi.id_tb_konsultasi',"DESC")
			->get_where('tb_konsultasi',$where);
	}

	public function dokumenView($where,$offset,$search){
		if (!empty($search)){
			$this->db->group_start()
				->like("LOWER(tb_dokumen.nama_dokumen)", strtolower($search))
				->or_like("LOWER(tb_dokumen_kode.nomor_dokumen)", strtolower($search))
				->or_like("LOWER(tb_dokumen.deskripsi_dokumen)", strtolower($search))
				->or_like("LOWER(tb_dokumen.bln_dokumen)", strtolower($search))
				->or_like("LOWER(tb_dokumen.thn_dokumen)", strtolower($search))
				->or_like("LOWER(tb_dokumen.jml_halaman)", strtolower($search))
				->or_like("LOWER(tb_jenis_dokumen.jenis_dokumen)", strtolower($search))
				->or_like("LOWER(tb_unit.nama_unit)", strtolower($search))
				->group_end();
		}
		if ($offset != -1){
			$this->db->limit(6,$offset);
		}
		return $this->db->select('tb_dokumen.*, tb_dokumen_kode.nomor_dokumen, tb_admin.id_tb_unit, tb_admin.nama_admin, 
				tb_admin.nipy, tb_unit.nama_unit, tb_jenis_dokumen.jenis_dokumen')
			->join('tb_dokumen_kode','tb_dokumen_kode.id_tb_dokumen_kode = tb_dokumen.id_tb_dokumen_kode')
			->join('tb_jenis_dokumen','tb_jenis_dokumen.id_tb_jenis_dokumen = tb_dokumen.id_tb_jenis_dokumen')
			->join('tb_admin','tb_admin.id_tb_admin = tb_dokumen.id_tb_admin')
			->join('tb_unit','tb_unit.id_tb_unit = tb_dokumen.id_tb_unit')
			->order_by('tb_dokumen.id_tb_dokumen',"DESC")
			->get_where('tb_dokumen',$where);
	}

	public function notificationView($offset,$search,$user){
		if (!empty($search)){
			$this->db->group_start()
				->like("LOWER(tb_konsultasi.nama_dokumen)", strtolower($search))
				->or_like("LOWER(tb_konsultasi_kode.nomor_dokumen)", strtolower($search))
				->or_like("LOWER(tb_konsultasi.deskripsi_dokumen)", strtolower($search))
				->or_like("LOWER(tb_konsultasi.bln_dokumen)", strtolower($search))
				->or_like("LOWER(tb_konsultasi.thn_dokumen)", strtolower($search))
				->or_like("LOWER(tb_konsultasi.jml_halaman)", strtolower($search))
				->or_like("LOWER(tb_konsultasi.stt_dokumen)", strtolower($search))
				->or_like("LOWER(tb_jenis_dokumen.jenis_dokumen)", strtolower($search))
				->or_like("LOWER(tb_unit.nama_unit)", strtolower($search))
				->group_end();
		}
		if ($offset!=NULL || $offset != -1){
			$this->db->limit(5,$offset);
		}
		$this->db->select('tb_konsultasi.*, tb_dokumen_kode.nomor_dokumen, tb_admin.nama_admin, tb_admin.nipy, tb_unit.nama_unit,
		tb_jenis_dokumen.jenis_dokumen')
			->join('tb_dokumen_kode','tb_dokumen_kode.id_tb_dokumen_kode = tb_konsultasi.id_tb_dokumen_kode','LEFT')
			->join('tb_jenis_dokumen','tb_jenis_dokumen.id_tb_jenis_dokumen = tb_konsultasi.id_tb_jenis_dokumen','LEFT')
			->join('tb_admin','tb_admin.id_tb_admin = tb_konsultasi.id_tb_admin')
			->join('tb_unit','tb_unit.id_tb_unit = tb_admin.id_tb_unit')
			->join('tb_konsultasi_unit_terkait','tb_konsultasi_unit_terkait.id_tb_konsultasi = tb_konsultasi.id_tb_konsultasi');
		if ($user=="superadmin"){
			$this->db->where(array('tb_konsultasi.del_flage'=>1, 'tb_konsultasi.stt_dokumen'=>"MENUNGGU"))
				->group_by('tb_konsultasi.id_tb_konsultasi');
		} else if ($user=="admin") {
			if (sess_get('jenis_unit')=="PENGENDALI"){
				$this->db
					->where(array('tb_konsultasi.del_flage'=>1,'tb_konsultasi.stt_dokumen'=>"MENUNGGU",'tb_konsultasi_unit_terkait.stt_revisi_unit'=>"MENUNGGU",'tb_konsultasi_unit_terkait.id_tb_unit'=>sess_get('id_unit')))
					->or_where(array('tb_konsultasi_unit_terkait.stt_revisi_unit'=>"REVISI"));
			} else {
				$this->db->where(array('tb_konsultasi.del_flage'=>1, 'tb_konsultasi.stt_dokumen'=>"MENUNGGU",'tb_konsultasi_unit_terkait.stt_revisi_unit'=>"REVISI"))
					->or_where(array('tb_konsultasi.stt_dokumen'=>"REVISI"));
			}
		}
		return $this->db->order_by('tb_konsultasi.mdate',"DESC")->get('tb_konsultasi');
	}

	public function api_detailDokumen($where){
		return $this->db->select('tb_dokumen.*, tb_dokumen_kode.nomor_dokumen, tb_dokumen_kode.perihal_dokumen, 
				tb_admin.nama_admin, tb_admin.nipy, tb_unit.nama_unit,
				tb_jenis_dokumen.jenis_dokumen')
			->join('tb_dokumen_kode','tb_dokumen_kode.id_tb_dokumen_kode = tb_dokumen.id_tb_dokumen_kode')
			->join('tb_jenis_dokumen','tb_jenis_dokumen.id_tb_jenis_dokumen = tb_dokumen.id_tb_jenis_dokumen')
			->join('tb_admin','tb_admin.id_tb_admin = tb_dokumen.id_tb_admin')
			->join('tb_unit','tb_unit.id_tb_unit = tb_dokumen.id_tb_unit')
			->get_where('tb_dokumen',$where);
	}

	public function api_detailKonsultasi($where){
		return $this->db->select('tb_konsultasi.*, tb_jenis_dokumen.jenis_dokumen,
				tb_dokumen_kode.nomor_dokumen, tb_dokumen_kode.perihal_dokumen, 
				tb_admin.nama_admin, tb_admin.nipy, tb_unit.nama_unit')
			->join('tb_dokumen_kode','tb_dokumen_kode.id_tb_dokumen_kode = tb_konsultasi.id_tb_dokumen_kode','LEFT')
			->join('tb_jenis_dokumen','tb_jenis_dokumen.id_tb_jenis_dokumen = tb_konsultasi.id_tb_jenis_dokumen','LEFT')
			->join('tb_admin','tb_admin.id_tb_admin = tb_konsultasi.id_tb_admin')
			->join('tb_unit','tb_unit.id_tb_unit = tb_konsultasi.id_tb_unit')
			->get_where('tb_konsultasi',$where);
	}

	public function api_getUnitTerkait($length,$start,$search,$where,$order){
		if(!empty($search)) {
			$this->db->group_start()
				->like("LOWER(tb_unit.nama_unit)", strtolower($search))
				->or_like("LOWER(tb_konsultasi_unit_terkait.stt_revisi_unit)", strtolower($search))
				->group_end();
		}
		if($length != -1 && !empty($length)) {
			$this->db->limit($length,$start);
		}
		return $this->db->select('tb_konsultasi_unit_terkait.*, tb_unit.nama_unit')
			->join('tb_unit','tb_unit.id_tb_unit = tb_konsultasi_unit_terkait.id_tb_unit')
			->order_by('tb_konsultasi_unit_terkait.id_tb_konsultasi_unit_terkait',$order)
			->get_where('tb_konsultasi_unit_terkait',$where);
	}

	public function api_getRevisiAdmin($id_tb_konsultasi){
		return $this->db->select('tb_konsultasi_revisi_admin.*, tb_admin.nama_admin')
			->join('tb_admin','tb_admin.id_tb_admin = tb_konsultasi_revisi_admin.id_tb_admin')
			->where(array('tb_konsultasi_revisi_admin.del_flage'=>1,'tb_konsultasi_revisi_admin.id_tb_konsultasi'=>$id_tb_konsultasi))
			->order_by('tb_konsultasi_revisi_admin.id_tb_konsultasi_revisi_admin',"DESC")
			->get('tb_konsultasi_revisi_admin');
	}

	public function api_getJenisDokumen($length,$start,$search,$order){
		if(!empty($search)) {
			$this->db->group_start()
				->like("LOWER(jenis_dokumen)", strtolower($search))
				->or_like("LOWER(keterangan)", strtolower($search))
				->group_end();
		}
		if($length != -1 && !empty($length)) {
			$this->db->limit($length,$start);
		}
		return $this->db->order_by('id_tb_jenis_dokumen',$order)
			->get_where('tb_jenis_dokumen',array('del_flage'=>1));
	}

	public function api_getNoDok($length,$start,$search,$where,$order){
		if(!empty($search)) {
			$this->db->group_start()
				->like("LOWER(tb_dokumen_kode.nomor_dokumen)", strtolower($search))
				->or_like("LOWER(tb_dokumen_kode.perihal_dokumen)", strtolower($search))
				->or_like("LOWER(tb_jenis_dokumen.jenis_dokumen)", strtolower($search))
				->group_end();
		}
		if($length != -1 && !empty($length)) {
			$this->db->limit($length,$start);
		}
		return $this->db->select('tb_dokumen_kode.*, tb_jenis_dokumen.jenis_dokumen')
			->join('tb_jenis_dokumen','tb_jenis_dokumen.id_tb_jenis_dokumen = tb_dokumen_kode.id_tb_jenis_dokumen')
			->order_by('tb_dokumen_kode.id_tb_dokumen_kode',$order)->get_where('tb_dokumen_kode',$where);
	}

	public function api_detailNoDok($where){
		return $this->db->select('tb_dokumen_kode.*, tb_jenis_dokumen.jenis_dokumen')
			->join('tb_jenis_dokumen','tb_jenis_dokumen.id_tb_jenis_dokumen = tb_dokumen_kode.id_tb_jenis_dokumen')
			->get_where('tb_dokumen_kode',$where);
	}

	public function api_getDafUnit($length,$start,$search,$where,$order){
		if(!empty($search)) {
			$this->db->group_start()
				->like("LOWER(nama_unit)", strtolower($search))
				->or_like("LOWER(keterangan)", strtolower($search))
				->group_end();
		}
		if($length != -1 && !empty($length)) {
			$this->db->limit($length,$start);
		}
		return $this->db->order_by('id_tb_unit',$order)
			->get_where('tb_unit',$where);
	}

	public function api_getSuperadmin($length,$start,$search,$where,$order){
		if(!empty($search)) {
			$this->db->group_start()
				->like("LOWER(tb_admin.nama_admin)", strtolower($search))
				->or_like("LOWER(tb_admin.nipy)", strtolower($search))
				->or_like("LOWER(tb_admin.jenis_unit)", strtolower($search))
				->or_like("LOWER(tb_unit.nama_unit)", strtolower($search))
				->group_end();
		}
		if($length != -1 && !empty($length)) {
			$this->db->limit($length,$start);
		}
		return $this->db->select('tb_admin.*, tb_unit.nama_unit')
			->join('tb_unit','tb_unit.id_tb_unit = tb_admin.id_tb_unit')
			->order_by('tb_admin.id_tb_admin',$order)
			->get_where('tb_admin',$where);
	}

	public function api_getAdmin($length,$start,$search,$where,$order){
		if(!empty($search)) {
			$this->db->group_start()
				->like("LOWER(tb_admin.nama_admin)", strtolower($search))
				->or_like("LOWER(tb_admin.nipy)", strtolower($search))
				->or_like("LOWER(tb_admin.jenis_unit)", strtolower($search))
				->or_like("LOWER(tb_unit.nama_unit)", strtolower($search))
				->group_end();
		}
		if($length != -1 && !empty($length)) {
			$this->db->limit($length,$start);
		}
		return $this->db->select('tb_admin.*, tb_unit.nama_unit')
			->join('tb_unit','tb_unit.id_tb_unit = tb_admin.id_tb_unit')
			->order_by('tb_admin.id_tb_admin',$order)
			->get_where('tb_admin',$where);
	}

	public function api_getUser($length,$start,$search,$where,$order){
		if(!empty($search)) {
			$this->db->group_start()
				->like("LOWER(nama_user)", strtolower($search))
				->or_like("nipy", strtolower($search))
				->group_end();
		}
		if($length != -1 && !empty($length)) {
			$this->db->limit($length,$start);
		}
		return $this->db->order_by('id_tb_user',$order)
			->get_where('tb_user',$where);
	}

	public function api_getLaporanDokumen($length,$start,$where,$order="ASC"){
		if($length != -1 && !empty($length)) {
			$this->db->limit($length,$start);
		}
		return $this->db->select('tb_dokumen.*, tb_admin.nama_admin, tb_unit.nama_unit, tb_dokumen_kode.nomor_dokumen, 
				tb_dokumen_kode.perihal_dokumen, tb_jenis_dokumen.jenis_dokumen')
			->join('tb_admin','tb_admin.id_tb_admin = tb_dokumen.id_tb_admin')
			->join('tb_unit','tb_unit.id_tb_unit = tb_dokumen.id_tb_unit')
			->join('tb_dokumen_kode','tb_dokumen_kode.id_tb_dokumen_kode = tb_dokumen.id_tb_dokumen_kode')
			->join('tb_jenis_dokumen','tb_jenis_dokumen.id_tb_jenis_dokumen = tb_dokumen.id_tb_jenis_dokumen')
			->order_by('tb_dokumen.id_tb_dokumen',$order)
			->get_where('tb_dokumen',$where);
	}

	public function api_getLaporanKonsultasi($length,$start,$where,$order="ASC"){
		if($length != -1 && !empty($length)) {
			$this->db->limit($length,$start);
		}
		return $this->db->select('tb_konsultasi.*, tb_admin.nama_admin, tb_unit.nama_unit, tb_dokumen_kode.nomor_dokumen, 
				tb_dokumen_kode.perihal_dokumen, tb_jenis_dokumen.jenis_dokumen')
			->join('tb_admin','tb_admin.id_tb_admin = tb_konsultasi.id_tb_admin')
			->join('tb_unit','tb_unit.id_tb_unit = tb_admin.id_tb_unit')
			->join('tb_dokumen_kode','tb_dokumen_kode.id_tb_dokumen_kode = tb_konsultasi.id_tb_dokumen_kode')
			->join('tb_jenis_dokumen','tb_jenis_dokumen.id_tb_jenis_dokumen = tb_konsultasi.id_tb_jenis_dokumen')
			->order_by('tb_konsultasi.id_tb_konsultasi',$order)
			->get_where('tb_konsultasi',$where);
	}

	public function api_getLaporanJendok($length,$start,$where,$order="ASC"){
		if($length != -1 && !empty($length)) {
			$this->db->limit($length,$start);
		}
		return $this->db->order_by('id_tb_jenis_dokumen',$order)
			->get_where('tb_jenis_dokumen',$where);
	}

	public function api_getLaporanNodok($length,$start,$where,$order="ASC"){
		if($length != -1 && !empty($length)) {
			$this->db->limit($length,$start);
		}
		return $this->db->select('tb_dokumen_kode.*, tb_jenis_dokumen.jenis_dokumen')
			->join('tb_jenis_dokumen','tb_jenis_dokumen.id_tb_jenis_dokumen = tb_dokumen_kode.id_tb_jenis_dokumen')
			->order_by('tb_dokumen_kode.id_tb_dokumen_kode',$order)
			->get_where('tb_dokumen_kode',$where);
	}

	public function api_getLaporanUnit($length,$start,$where,$order="ASC"){
		if($length != -1 && !empty($length)) {
			$this->db->limit($length,$start);
		}
		return $this->db->order_by('id_tb_unit',$order)
			->get_where('tb_unit',$where);
	}

	public function api_getLaporanAdmin($length,$start,$where,$order="ASC"){
		if($length != -1 && !empty($length)) {
			$this->db->limit($length,$start);
		}
		return $this->db->select('tb_admin.*, tb_unit.nama_unit')
			->join('tb_unit','tb_unit.id_tb_unit = tb_admin.id_tb_unit')
			->order_by('tb_admin.id_tb_admin',$order)
			->get_where('tb_admin',$where);
	}

	public function api_getLaporanPengguna($length,$start,$where,$order="ASC"){
		if($length != -1 && !empty($length)) {
			$this->db->limit($length,$start);
		}
		return $this->db->order_by('id_tb_user',$order)
			->get_where('tb_user',$where);
	}

	public function selectKode($limit,$offset,$search,$where){
		$this->db->select("tb_dokumen_kode.id_tb_dokumen_kode as id, CONCAT(tb_jenis_dokumen.jenis_dokumen,' - ',tb_dokumen_kode.nomor_dokumen) as text");
		if (!empty($limit)){
			$this->db->limit($limit,$offset);
		}
		if(!empty($search)) {
			$this->db->group_start()->like("tb_dokumen_kode.nomor_dokumen", strtolower($search))->group_end();
		}
		return $this->db->join('tb_jenis_dokumen',"tb_jenis_dokumen.id_tb_jenis_dokumen = tb_dokumen_kode.id_tb_jenis_dokumen")
			->get_where('tb_dokumen_kode',$where);
	}

	public function selectUnit($limit,$offset,$search){
		$this->db->select("id_tb_unit as id, nama_unit as text");
		if (!empty($limit)){
			$this->db->limit($limit,$offset);
		}
		if(!empty($search)) {
			$this->db->group_start()->like("nama_unit", strtolower($search))->group_end();
		}
		return $this->db->get_where('tb_unit',array('del_flage'=>1));
	}

	public function selectJenisDokumen($limit,$offset,$search,$where){
		$this->db->select("id_tb_jenis_dokumen as id, jenis_dokumen as text");
		if (!empty($limit)){
			$this->db->limit($limit,$offset);
		}
		if(!empty($search)) {
			$this->db->group_start()->like("jenis_dokumen", strtolower($search))->group_end();
		}
		return $this->db->get_where('tb_jenis_dokumen',$where);
	}
}
