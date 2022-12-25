<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function post($name,$security=TRUE){
    $CI =& get_instance();
    return $CI->input->post($name,$security);
}
function get($name,$security=TRUE){
    $CI =& get_instance();
    return $CI->input->get($name,$security);
}
function sess_set($session){
    $CI =& get_instance();
    return $CI->session->set_userdata($session);
}
function sess_get($key){
    $CI =& get_instance();
    return $CI->session->userdata($key);
}
function db_input($tb, $input){
    $CI =& get_instance();
    $CI->db->insert($tb,$input);
    return $CI->db->insert_id();
}
function db_get($tb){
    $CI =& get_instance();
    return $CI->db->get($tb);
}
function db_update($tb, $where, $update){
    $CI =& get_instance();
    return $CI->db->where($where)->update($tb,$update);
}
function db_where($tb, $where){
    $CI =& get_instance();
    return $CI->db->get_where($tb,$where);
}
function db_delete($tb,$where){
    $CI =& get_instance();
    return $CI->db->where($where)->delete($tb);
}
function db_view_unitTerkaitKonsultasi($id_konsultasi){
    $CI =& get_instance();
    return $CI->db->select('tb_unit.id_tb_unit, tb_unit.nama_unit, tb_konsultasi_unit_terkait.*')
		->join('tb_unit','tb_unit.id_tb_unit = tb_konsultasi_unit_terkait.id_tb_unit')
		->get_where('tb_konsultasi_unit_terkait',array('tb_konsultasi_unit_terkait.del_flage'=>1,'tb_konsultasi_unit_terkait.id_tb_konsultasi'=>$id_konsultasi));
}
function db_jenisDokumen(){
    $CI =& get_instance();
    return $CI->db->get_where('tb_jenis_dokumen',array('del_flage'=>1))->result();
}
function db_view_unitTerkait($id_dokumen){
    $CI =& get_instance();
    return $CI->db->select('tb_unit.id_tb_unit, tb_unit.nama_unit, tb_dokumen_unit_terkait.*')
		->join('tb_unit','tb_unit.id_tb_unit = tb_dokumen_unit_terkait.id_tb_unit')
		->get_where('tb_dokumen_unit_terkait',array('tb_dokumen_unit_terkait.del_flage'=>1,'tb_dokumen_unit_terkait.id_tb_dokumen'=>$id_dokumen));
}
function db_notif_konsul_super(){
	$CI =& get_instance();
	$total = $CI->db->where(array('del_flage'=>1,'stt_dokumen'=>"Menunggu"))
		->or_where('stt_dokumen',"Menunggu Revisi P2M")->get('tb_konsultasi')->num_rows();
	if ($total>0){
		return '<span class="right badge badge-warning">'.$total.'</span>';
	}
}
function db_notif_konsul_unit(){
	$CI =& get_instance();
	if (sess_get('jenis_unit')=="PENGENDALI"){
		$total = $CI->db
			->where(array('tb_konsultasi.del_flage'=>1,'tb_konsultasi_unit_terkait.del_flage'=>1,'tb_konsultasi.stt_dokumen'=>"MENUNGGU",
			'tb_konsultasi_unit_terkait.stt_revisi_unit'=>"MENUNGGU",'tb_konsultasi_unit_terkait.id_tb_unit'=>sess_get('id_unit')))
			->join('tb_konsultasi','tb_konsultasi.id_tb_konsultasi = tb_konsultasi_unit_terkait.id_tb_konsultasi')
			->get('tb_konsultasi_unit_terkait')->num_rows();
	} else {
		$total = $CI->db->where(array('tb_konsultasi.del_flage'=>1,'tb_konsultasi.id_tb_unit'=>sess_get('id_unit'),
				'tb_konsultasi.stt_dokumen'=>"MENUNGGU",'tb_konsultasi_unit_terkait.stt_revisi_unit'=>"REVISI"))
			->join('tb_konsultasi_unit_terkait','tb_konsultasi_unit_terkait.id_tb_konsultasi = tb_konsultasi.id_tb_konsultasi')
			->get('tb_konsultasi')->num_rows();
	}
	if ($total>0){
		return '<span class="right badge badge-warning">'.$total.'</span>';
	}
}
function get_token() {
	$str1 = "1qw2er3ty4ui5op6lk7jh8gf9ds0azxcvbnm";
	$str2 = strrev($str1);
	$yyyy = intval(date('Y'));
	$mm = intval(date('m'));
	$dd = intval(date('d'));
	$date = implode("",[$yyyy,$mm,$dd]);
	$token = implode("",['espmi',$date]);
	for ($i=0; $i < strlen($str1); $i++) {
		$token = str_replace($str1[$i],$str2[$i],$token);
	}
	return $token;
}
function setTglIndo($cdate)
{
	$bulan=array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
	$hari=array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");
	if (empty($cdate)){
		return '';
	} else {
		$wkt_indo = strtotime($cdate);
		return $hari[date("w",$wkt_indo)].", ".date("j",$wkt_indo)." ".$bulan[date("n",$wkt_indo)]." ".date("Y",$wkt_indo);
	}
}
function getBulan(){
	return array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
}
function setJSON($response)
{
    $CI =& get_instance();
    $CI->output
        ->set_status_header(200)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response, JSON_PRETTY_PRINT))
        ->_display();
    exit;
}
function setResponseJson($status,$data=NULL){
    $response = array('response'=>array('status'=>$status,'data'=>$data));
    $CI =& get_instance();
    $CI->output
        ->set_status_header(200)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response, JSON_PRETTY_PRINT))
        ->_display();
    exit;
}
function get_date(){
    return date('Y-m-d H:i:s');
}
function waktu_lalu($timestamp){
    // date_default_timezone_set('Asia/Jakarta');
    $selisih = time() - strtotime($timestamp);
    $detik = $selisih;
    $menit = round($selisih / 60);
    $jam = round($selisih / 3600);
    $hari = round($selisih / 86400);
    $minggu = round($selisih / 604800);
    $bulan = round($selisih / 2419200);
    $tahun = round($selisih / 29030400);
    global $waktu_lalu;
    $waktu_jam = substr($waktu_lalu, 11, 5);
    if ($detik <= 30) {
        $waktu = ' baru saja';
    }
    elseif ($detik <= 60) {
        $waktu = $detik . ' detik yang lalu';
    }
    elseif ($menit <= 60) {
        $waktu = $menit . ' menit yang lalu';
    }
    elseif ($jam <= 24) {
        $waktu = $jam . ' jam yang lalu';
    }
    elseif ($hari <= 1) {
        $waktu = ' kemarin ' . $waktu_jam;
    }
    elseif ($hari <= 7) {
        $waktu = $hari . ' hari yang lalu ' . $waktu_jam;
    }
    elseif ($minggu <= 4) {
        $waktu = $minggu . ' minggu yang lalu ' . $waktu_jam;
    }
    elseif ($bulan <= 12) {
        $waktu = $bulan . ' bulan yang lalu ' . $waktu_jam;
    }
    else {
        $waktu = $tahun . ' tahun yang lalu ' . $waktu_jam;
    }
    return $waktu;
}
function set_btn_dokumen(){
	if (sess_get('id_unit')==11){
		return true;
	} else {
		$ck = db_where('tb_pengaturan',array('id_tb_pengaturan'=>1))->row()->value_1;
		if ($ck==1){
			return true;
		} else {
			return false;
		}
	}
}
