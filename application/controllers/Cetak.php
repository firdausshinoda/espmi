<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cetak extends CI_Controller
{
	public function __construct() {
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->library('template');
		$this->load->model('M_api');
		if (isset($this->session->userdata['espmi-superadmin'])!=TRUE){
			redirect(base_url());
		}
	}

	public function laporan_dokumen(){
		$jenis_dokumen = get('jenis_dokumen');
		$type = get('type');
		$where['tb_dokumen.del_flage']		= 1;
		if ($jenis_dokumen != "Semua"){
			$where['tb_dokumen.jenis_dokumen']	= $jenis_dokumen;
		}
		$stmt = $this->M_api->api_getLaporanDokumen(NULL,NULL,$where);
		if ($type=="PDF"){
			$this->load->helper('print_laporan_dokumen');
			$pdf = new Print_Laporan_Dokumen();
			$pdf->AddPage('L',"A4");
			$pdf->SetMargins(10,10,10);
			$pdf->kop();
			$pdf->isi($stmt);
			$pdf->Output("Laporan Dokumen Per ".str_replace(',','',setTglIndo(get_date())).".pdf",'I');
		} else if ($type=="EXCEL"){
			$this->load->library('Excel_generator');
			$excel = new PHPExcel();
			$excel->getProperties()->setCreator('Laporan Daftar Dokumen')
				->setLastModifiedBy('Laporan Daftar Dokumen')
				->setTitle("Laporan Daftar Dokumen")
				->setSubject("Laporan Daftar Dokumen")
				->setDescription("Laporan Daftar Dokumen")
				->setKeywords("Laporan Daftar Dokumen");

			$style_col = array(  'font' => array('bold' => true),
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
				),
				'borders' => array(
					'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
					'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
					'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
					'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
				)
			);

			$style_row = array(
				'alignment' => array(
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
				),
				'borders' => array(
					'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
					'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
					'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
					'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
				)
			);

			$excel->setActiveSheetIndex(0)->setCellValue('A1', "Laporan Daftar Dokumen");
			$excel->getActiveSheet()->mergeCells('A1:L1');

			$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
			$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
			$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$excel->setActiveSheetIndex(0)->setCellValue('A3', "NO");
			$excel->setActiveSheetIndex(0)->setCellValue('B3', "Nama Dokumen");
			$excel->setActiveSheetIndex(0)->setCellValue('C3', "Nomor Dokumen");
			$excel->setActiveSheetIndex(0)->setCellValue('D3', "Jenis Dokumen");
			$excel->setActiveSheetIndex(0)->setCellValue('E3', "Jumlah Halaman");
			$excel->setActiveSheetIndex(0)->setCellValue('F3', "Revisi");
			$excel->setActiveSheetIndex(0)->setCellValue('G3', "Oleh Unit");
			$excel->setActiveSheetIndex(0)->setCellValue('H3', "Unit Terkait");
			$excel->setActiveSheetIndex(0)->setCellValue('I3', "Status Dokumen");
			$excel->setActiveSheetIndex(0)->setCellValue('J3', "Prihal Dokumen");
			$excel->setActiveSheetIndex(0)->setCellValue('K3', "Deskripsi Dokumen");
			$excel->setActiveSheetIndex(0)->setCellValue('L3', "Tanggal Publis");

			$excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('G3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('H3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('I3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('J3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('K3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('L3')->applyFromArray($style_col);

			$excel->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
			$excel->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
			$excel->getActiveSheet()->getRowDimension('3')->setRowHeight(20);

			$no = 1;
			$numrow = 4;
			foreach($stmt->result() as $item) {
				$unit_terkait = "";
				foreach (db_view_unitTerkait($item->id_tb_dokumen)->result() as $it_unit){
					if (empty($unit_terkait)){
						$unit_terkait .= $it_unit->nama_unit;
					} else {
						$unit_terkait .= ", ".$it_unit->nama_unit;
					}
				}

				$excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $no);
				$excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $item->nama_dokumen);
				$excel->setActiveSheetIndex(0)->setCellValueExplicit('C' . $numrow, $item->nomor_dokumen, PHPExcel_Cell_DataType::TYPE_STRING);
				$excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $item->jenis_dokumen);
				$excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $item->jml_halaman);
				$excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, $item->revisi);
				$excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, $item->nama_unit);
				$excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, $unit_terkait);
				$excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, "PUBLIS");
				$excel->setActiveSheetIndex(0)->setCellValue('J' . $numrow, $item->perihal_dokumen);
				$excel->setActiveSheetIndex(0)->setCellValue('K' . $numrow, $item->deskripsi_dokumen);
				$excel->setActiveSheetIndex(0)->setCellValue('L' . $numrow, $item->cdate);

				$excel->getActiveSheet()->getRowDimension($numrow)->setRowHeight(20);
				$no++;
				$numrow++;
			}

			$excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
			$excel->getActiveSheet()->getColumnDimension('B')->setWidth(50);
			$excel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
			$excel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
			$excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
			$excel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
			$excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
			$excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
			$excel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
			$excel->getActiveSheet()->getColumnDimension('J')->setWidth(70);
			$excel->getActiveSheet()->getColumnDimension('K')->setWidth(70);
			$excel->getActiveSheet()->getColumnDimension('L')->setWidth(30);

			$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
			$excel->getActiveSheet(0)->setTitle("Laporan Daftar Dokumen");
			$excel->setActiveSheetIndex(0);

			// Proses file excel
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment; filename="Laporan Daftar Dokumen.xlsx"');

			// Set nama file excel nya
			header('Cache-Control: max-age=0');
			$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
			$write->save('php://output');
		} else {
			redirect(base_url());
		}
	}

	public function laporan_konsultasi(){
		$jenis_dokumen = get('jenis_dokumen');
		$type = get('type');
		$where['tb_konsultasi.del_flage']		= 1;
		if ($jenis_dokumen != "Semua"){
			$where['tb_konsultasi.id_tb_jenis_dokumen']	= $jenis_dokumen;
		}
		$stmt = $this->M_api->api_getLaporanKonsultasi(NULL,NULL,$where);
		if ($type=="PDF"){
			$this->load->helper('print_laporan_konsultasi');
			$pdf = new Print_Laporan_Konsultasi();
			$pdf->AddPage('L',"A4");
			$pdf->SetMargins(10,10,10);
			$pdf->kop();
			$pdf->isi($stmt);
			$pdf->Output("Laporan Konesultasi Per ".str_replace(',','',setTglIndo(get_date())).".pdf",'I');
		} else if ($type=="EXCEL"){
			$this->load->library('Excel_generator');
			$excel = new PHPExcel();
			$excel->getProperties()->setCreator('Laporan Daftar Konsultasi')
				->setLastModifiedBy('Laporan Daftar Konsultasi')
				->setTitle("Laporan Daftar Konsultasi")
				->setSubject("Laporan Daftar Konsultasi")
				->setDescription("Laporan Daftar Konsultasi")
				->setKeywords("Laporan Daftar Konsultasi");

			$style_col = array(  'font' => array('bold' => true),
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
				),
				'borders' => array(
					'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
					'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
					'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
					'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
				)
			);

			$style_row = array(
				'alignment' => array(
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
				),
				'borders' => array(
					'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
					'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
					'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
					'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
				)
			);

			$excel->setActiveSheetIndex(0)->setCellValue('A1', "Laporan Daftar Konsultasi");
			$excel->getActiveSheet()->mergeCells('A1:L1');

			$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
			$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
			$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$excel->setActiveSheetIndex(0)->setCellValue('A3', "NO");
			$excel->setActiveSheetIndex(0)->setCellValue('B3', "Nama Dokumen");
			$excel->setActiveSheetIndex(0)->setCellValue('C3', "Nomor Dokumen");
			$excel->setActiveSheetIndex(0)->setCellValue('D3', "Jenis Dokumen");
			$excel->setActiveSheetIndex(0)->setCellValue('E3', "Jumlah Halaman");
			$excel->setActiveSheetIndex(0)->setCellValue('F3', "Revisi");
			$excel->setActiveSheetIndex(0)->setCellValue('G3', "Oleh Unit");
			$excel->setActiveSheetIndex(0)->setCellValue('H3', "Unit Terkait");
			$excel->setActiveSheetIndex(0)->setCellValue('I3', "Status Dokumen");
			$excel->setActiveSheetIndex(0)->setCellValue('J3', "Prihal Dokumen");
			$excel->setActiveSheetIndex(0)->setCellValue('K3', "Deskripsi Dokumen");
			$excel->setActiveSheetIndex(0)->setCellValue('L3', "Tanggal Publis");

			$excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('G3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('H3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('I3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('J3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('K3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('L3')->applyFromArray($style_col);

			$excel->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
			$excel->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
			$excel->getActiveSheet()->getRowDimension('3')->setRowHeight(20);

			$no = 1;
			$numrow = 4;
			foreach($stmt->result() as $item) {
				$unit_terkait = "";
				foreach (db_view_unitTerkaitKonsultasi($item->id_tb_konsultasi)->result() as $it_unit){
					if (empty($unit_terkait)){
						$unit_terkait .= $it_unit->nama_unit;
					} else {
						$unit_terkait .= ", ".$it_unit->nama_unit;
					}
				}

				$excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $no);
				$excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $item->nama_dokumen);
				$excel->setActiveSheetIndex(0)->setCellValueExplicit('C' . $numrow, $item->nomor_dokumen, PHPExcel_Cell_DataType::TYPE_STRING);
				$excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $item->jenis_dokumen);
				$excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $item->jml_halaman);
				$excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, $item->revisi);
				$excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, $item->nama_unit);
				$excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, $unit_terkait);
				$excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, $item->stt_dokumen);
				$excel->setActiveSheetIndex(0)->setCellValue('J' . $numrow, $item->perihal_dokumen);
				$excel->setActiveSheetIndex(0)->setCellValue('K' . $numrow, $item->deskripsi_dokumen);
				$excel->setActiveSheetIndex(0)->setCellValue('L' . $numrow, $item->publis_date);

				$excel->getActiveSheet()->getRowDimension($numrow)->setRowHeight(20);
				$no++;
				$numrow++;
			}

			$excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
			$excel->getActiveSheet()->getColumnDimension('B')->setWidth(50);
			$excel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
			$excel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
			$excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
			$excel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
			$excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
			$excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
			$excel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
			$excel->getActiveSheet()->getColumnDimension('J')->setWidth(70);
			$excel->getActiveSheet()->getColumnDimension('K')->setWidth(70);
			$excel->getActiveSheet()->getColumnDimension('L')->setWidth(30);

			$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
			$excel->getActiveSheet(0)->setTitle("Laporan Daftar Konsultasi");
			$excel->setActiveSheetIndex(0);

			// Proses file excel
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment; filename="Laporan Daftar Konsultasi.xlsx"');

			// Set nama file excel nya
			header('Cache-Control: max-age=0');
			$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
			$write->save('php://output');
		} else {
			redirect(base_url());
		}
	}

	public function laporan_jendok(){
		$type = get('type');
		$where['del_flage']		= 1;
		$stmt = $this->M_api->api_getLaporanJendok(NULL,NULL,$where);
		if ($type=="PDF"){
			$this->load->helper('print_laporan_jendok');
			$pdf = new Print_Laporan_Jendok();
			$pdf->AddPage('P',"A4");
			$pdf->SetMargins(10,10,10);
			$pdf->kop();
			$pdf->isi($stmt);
			$pdf->Output("Laporan Jenis Dokumen Per ".str_replace(',','',setTglIndo(get_date())).".pdf",'I');
		} else if ($type=="EXCEL"){
			$this->load->library('Excel_generator');
			$excel = new PHPExcel();
			$excel->getProperties()->setCreator('Laporan Jenis Nomor Dokumen')
				->setLastModifiedBy('Laporan Jenis Nomor Dokumen')
				->setTitle("Laporan Jenis Nomor Dokumen")
				->setSubject("Laporan Jenis Nomor Dokumen")
				->setDescription("Laporan Jenis Nomor Dokumen")
				->setKeywords("Laporan Jenis Nomor Dokumen");

			$style_col = array(  'font' => array('bold' => true),
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
				),
				'borders' => array(
					'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
					'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
					'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
					'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
				)
			);

			$style_row = array(
				'alignment' => array(
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
				),
				'borders' => array(
					'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
					'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
					'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
					'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
				)
			);

			$excel->setActiveSheetIndex(0)->setCellValue('A1', "Laporan Jenis Nomor Dokumen");
			$excel->getActiveSheet()->mergeCells('A1:E1');

			$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
			$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
			$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$excel->setActiveSheetIndex(0)->setCellValue('A3', "NO");
			$excel->setActiveSheetIndex(0)->setCellValue('B3', "Jenis Dokumen");
			$excel->setActiveSheetIndex(0)->setCellValue('C3', "Keterangan");
			$excel->setActiveSheetIndex(0)->setCellValue('D3', "Tanggal Ditambahkan");

			$excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);

			$excel->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
			$excel->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
			$excel->getActiveSheet()->getRowDimension('3')->setRowHeight(20);

			$no = 1;
			$numrow = 4;
			foreach($stmt->result() as $item) {
				$excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $no);
				$excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $item->jenis_dokumen);
				$excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $item->keterangan);
				$excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $item->cdate);

				$excel->getActiveSheet()->getRowDimension($numrow)->setRowHeight(20);
				$no++;
				$numrow++;
			}

			$excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
			$excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
			$excel->getActiveSheet()->getColumnDimension('C')->setWidth(70);
			$excel->getActiveSheet()->getColumnDimension('D')->setWidth(30);

			$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
			$excel->getActiveSheet(0)->setTitle("Laporan Daftar Jenis Dokumen");
			$excel->setActiveSheetIndex(0);

			// Proses file excel
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment; filename="Laporan Daftar Jenis Dokumen.xlsx"');

			// Set nama file excel nya
			header('Cache-Control: max-age=0');
			$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
			$write->save('php://output');
		} else {
			redirect(base_url());
		}
	}

	public function laporan_nodok(){
		$jenis_dokumen = get('jenis_dokumen');
		$type = get('type');
		$where['tb_dokumen_kode.del_flage']		= 1;
		if ($jenis_dokumen != "Semua"){
			$where['tb_dokumen_kode.jenis_dokumen']	= $jenis_dokumen;
		}
		$stmt = $this->M_api->api_getLaporanNodok(NULL,NULL,$where);
		if ($type=="PDF"){
			$this->load->helper('print_laporan_nodok');
			$pdf = new Print_Laporan_Nodok();
			$pdf->AddPage('P',"A4");
			$pdf->SetMargins(10,10,10);
			$pdf->kop();
			$pdf->isi($stmt);
			$pdf->Output("Laporan Nomor Dokumen Per ".str_replace(',','',setTglIndo(get_date())).".pdf",'I');
		} else if ($type=="EXCEL"){
			$this->load->library('Excel_generator');
			$excel = new PHPExcel();
			$excel->getProperties()->setCreator('Laporan Daftar Nomor Dokumen')
				->setLastModifiedBy('Laporan Daftar Nomor Dokumen')
				->setTitle("Laporan Daftar Nomor Dokumen")
				->setSubject("Laporan Daftar Nomor Dokumen")
				->setDescription("Laporan Daftar Nomor Dokumen")
				->setKeywords("Laporan Daftar Nomor Dokumen");

			$style_col = array(  'font' => array('bold' => true),
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
				),
				'borders' => array(
					'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
					'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
					'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
					'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
				)
			);

			$style_row = array(
				'alignment' => array(
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
				),
				'borders' => array(
					'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
					'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
					'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
					'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
				)
			);

			$excel->setActiveSheetIndex(0)->setCellValue('A1', "Laporan Daftar Nomor Dokumen");
			$excel->getActiveSheet()->mergeCells('A1:E1');

			$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
			$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
			$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$excel->setActiveSheetIndex(0)->setCellValue('A3', "NO");
			$excel->setActiveSheetIndex(0)->setCellValue('B3', "Nomor Dokumen");
			$excel->setActiveSheetIndex(0)->setCellValue('C3', "Jenis Dokumen");
			$excel->setActiveSheetIndex(0)->setCellValue('D3', "Perihal Dokumen");
			$excel->setActiveSheetIndex(0)->setCellValue('E3', "Tanggal Ditambahkan");

			$excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);

			$excel->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
			$excel->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
			$excel->getActiveSheet()->getRowDimension('3')->setRowHeight(20);

			$no = 1;
			$numrow = 4;
			foreach($stmt->result() as $item) {
				$excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $no);
				$excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $item->nomor_dokumen);
				$excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $item->jenis_dokumen);
				$excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $item->perihal_dokumen);
				$excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $item->cdate);

				$excel->getActiveSheet()->getRowDimension($numrow)->setRowHeight(20);
				$no++;
				$numrow++;
			}

			$excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
			$excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
			$excel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
			$excel->getActiveSheet()->getColumnDimension('D')->setWidth(70);
			$excel->getActiveSheet()->getColumnDimension('E')->setWidth(30);

			$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
			$excel->getActiveSheet(0)->setTitle("Laporan Daftar Nomor Dokumen");
			$excel->setActiveSheetIndex(0);

			// Proses file excel
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment; filename="Laporan Daftar Nomor Dokumen.xlsx"');

			// Set nama file excel nya
			header('Cache-Control: max-age=0');
			$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
			$write->save('php://output');
		} else {
			redirect(base_url());
		}
	}

	public function laporan_unit(){
		$type = get('type');
		$where['del_flage']		= 1;
		$stmt = $this->M_api->api_getLaporanUnit(NULL,NULL,$where);
		if ($type=="PDF"){
			$this->load->helper('print_laporan_unit');
			$pdf = new Print_Laporan_Unit();
			$pdf->AddPage('P',"A4");
			$pdf->SetMargins(10,10,10);
			$pdf->kop();
			$pdf->isi($stmt);
			$pdf->Output("Laporan Unit Per ".str_replace(',','',setTglIndo(get_date())).".pdf",'I');
		} else if ($type=="EXCEL"){
			$this->load->library('Excel_generator');
			$excel = new PHPExcel();
			$excel->getProperties()->setCreator('Laporan Daftar Unit')
				->setLastModifiedBy('Laporan Daftar Unit')
				->setTitle("Laporan Daftar Unit")
				->setSubject("Laporan Daftar Unit")
				->setDescription("Laporan Daftar Unit")
				->setKeywords("Laporan Daftar Unit");

			$style_col = array(  'font' => array('bold' => true),
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
				),
				'borders' => array(
					'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
					'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
					'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
					'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
				)
			);

			$style_row = array(
				'alignment' => array(
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
				),
				'borders' => array(
					'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
					'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
					'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
					'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
				)
			);

			$excel->setActiveSheetIndex(0)->setCellValue('A1', "Laporan Daftar Unit");
			$excel->getActiveSheet()->mergeCells('A1:D1');

			$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
			$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
			$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$excel->setActiveSheetIndex(0)->setCellValue('A3', "NO");
			$excel->setActiveSheetIndex(0)->setCellValue('B3', "Nama Unit");
			$excel->setActiveSheetIndex(0)->setCellValue('C3', "Keterangan");
			$excel->setActiveSheetIndex(0)->setCellValue('D3', "Tanggal Ditambahkan");

			$excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);

			$excel->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
			$excel->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
			$excel->getActiveSheet()->getRowDimension('3')->setRowHeight(20);

			$no = 1;
			$numrow = 4;
			foreach($stmt->result() as $item) {
				$excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $no);
				$excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $item->nama_unit);
				$excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $item->keterangan);
				$excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $item->cdate);

				$excel->getActiveSheet()->getRowDimension($numrow)->setRowHeight(20);
				$no++;
				$numrow++;
			}

			$excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
			$excel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
			$excel->getActiveSheet()->getColumnDimension('C')->setWidth(50);
			$excel->getActiveSheet()->getColumnDimension('D')->setWidth(30);

			$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
			$excel->getActiveSheet(0)->setTitle("Laporan Daftar Unit");
			$excel->setActiveSheetIndex(0);

			// Proses file excel
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment; filename="Laporan Daftar Unit.xlsx"');

			// Set nama file excel nya
			header('Cache-Control: max-age=0');
			$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
			$write->save('php://output');
		} else {
			redirect(base_url());
		}
	}

	public function laporan_admin(){
		$type = get('type');
		$where['tb_admin.del_flage']		= 1;
		$where['tb_admin.jenis_admin'] 	= "ADMIN";
		if (get('jenis_unit') != "Semua"){
			$where['tb_admin.jenis_unit'] = get('jenis_unit');
		}
		$stmt = $this->M_api->api_getLaporanAdmin(NULL,NULL,$where);
		if ($type=="PDF"){
			$this->load->helper('print_laporan_pengguna_unit');
			$pdf = new Print_Laporan_Pengguna_Unit();
			$pdf->AddPage('P',"A4");
			$pdf->SetMargins(10,10,10);
			$pdf->kop();
			$pdf->isi($stmt);
			$pdf->Output("Laporan Pengguna Unit Per ".str_replace(',','',setTglIndo(get_date())).".pdf",'I');
		} else if ($type=="EXCEL"){
			$this->load->library('Excel_generator');
			$excel = new PHPExcel();
			$excel->getProperties()->setCreator('Laporan Daftar Pengguna Unit')
				->setLastModifiedBy('Laporan Daftar Pengguna Unit')
				->setTitle("Laporan Daftar Pengguna Unit")
				->setSubject("Laporan Daftar Pengguna Unit")
				->setDescription("Laporan Daftar Pengguna Unit")
				->setKeywords("Laporan Daftar Pengguna Unit");

			$style_col = array(  'font' => array('bold' => true),
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
				),
				'borders' => array(
					'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
					'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
					'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
					'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
				)
			);

			$style_row = array(
				'alignment' => array(
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
				),
				'borders' => array(
					'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
					'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
					'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
					'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
				)
			);

			$excel->setActiveSheetIndex(0)->setCellValue('A1', "Laporan Daftar Pengguna Unit");
			$excel->getActiveSheet()->mergeCells('A1:F1');

			$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
			$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
			$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$excel->setActiveSheetIndex(0)->setCellValue('A3', "NO");
			$excel->setActiveSheetIndex(0)->setCellValue('B3', "Nama");
			$excel->setActiveSheetIndex(0)->setCellValue('C3', "NIPY");
			$excel->setActiveSheetIndex(0)->setCellValue('D3', "Unit");
			$excel->setActiveSheetIndex(0)->setCellValue('E3', "Jenis Unit");
			$excel->setActiveSheetIndex(0)->setCellValue('F3', "Tanggal Ditambahkan");

			$excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);

			$excel->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
			$excel->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
			$excel->getActiveSheet()->getRowDimension('3')->setRowHeight(20);

			$no = 1;
			$numrow = 4;
			foreach($stmt->result() as $item) {
				$excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $no);
				$excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $item->nama_admin);
				$excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $item->nipy);
				$excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $item->nama_unit);
				$excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $item->jenis_unit);
				$excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, $item->cdate);

				$excel->getActiveSheet()->getRowDimension($numrow)->setRowHeight(20);
				$no++;
				$numrow++;
			}

			$excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
			$excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
			$excel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
			$excel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
			$excel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
			$excel->getActiveSheet()->getColumnDimension('F')->setWidth(30);

			$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
			$excel->getActiveSheet(0)->setTitle("Laporan Daftar Pengguna Unit");
			$excel->setActiveSheetIndex(0);

			// Proses file excel
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment; filename="Laporan Daftar Pengguna Unit.xlsx"');

			// Set nama file excel nya
			header('Cache-Control: max-age=0');
			$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
			$write->save('php://output');
		} else {
			redirect(base_url());
		}
	}

	public function laporan_pengguna(){
		$type = get('type');
		$where['del_flage']		= 1;
		$stmt = $this->M_api->api_getLaporanPengguna(NULL,NULL,$where);
		if ($type=="PDF"){
			$this->load->helper('print_laporan_pengguna_biasa');
			$pdf = new Print_Laporan_Pengguna_Biasa();
			$pdf->AddPage('P',"A4");
			$pdf->SetMargins(10,10,10);
			$pdf->kop();
			$pdf->isi($stmt);
			$pdf->Output("Laporan Pengguna Biasa Per ".str_replace(',','',setTglIndo(get_date())).".pdf",'I');
		} else if ($type=="EXCEL"){
			$this->load->library('Excel_generator');
			$excel = new PHPExcel();
			$excel->getProperties()->setCreator('Laporan Daftar Pengguna Biasa')
				->setLastModifiedBy('Laporan Daftar Pengguna Biasa')
				->setTitle("Laporan Daftar Pengguna Biasa")
				->setSubject("Laporan Daftar Pengguna Biasa")
				->setDescription("Laporan Daftar Pengguna Biasa")
				->setKeywords("Laporan Daftar Pengguna Biasa");

			$style_col = array(  'font' => array('bold' => true),
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
				),
				'borders' => array(
					'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
					'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
					'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
					'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
				)
			);

			$style_row = array(
				'alignment' => array(
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
				),
				'borders' => array(
					'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
					'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
					'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
					'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
				)
			);

			$excel->setActiveSheetIndex(0)->setCellValue('A1', "Laporan Daftar Pengguna Biasa");
			$excel->getActiveSheet()->mergeCells('A1:F1');

			$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
			$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
			$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$excel->setActiveSheetIndex(0)->setCellValue('A3', "NO");
			$excel->setActiveSheetIndex(0)->setCellValue('B3', "Nama");
			$excel->setActiveSheetIndex(0)->setCellValue('C3', "NIPY");
			$excel->setActiveSheetIndex(0)->setCellValue('D3', "Tanggal Ditambahkan");

			$excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
			$excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);

			$excel->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
			$excel->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
			$excel->getActiveSheet()->getRowDimension('3')->setRowHeight(20);

			$no = 1;
			$numrow = 4;
			foreach($stmt->result() as $item) {
				$excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $no);
				$excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $item->nama_user);
				$excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $item->nipy);
				$excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $item->cdate);

				$excel->getActiveSheet()->getRowDimension($numrow)->setRowHeight(20);
				$no++;
				$numrow++;
			}

			$excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
			$excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
			$excel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
			$excel->getActiveSheet()->getColumnDimension('D')->setWidth(40);

			$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
			$excel->getActiveSheet(0)->setTitle("Laporan Daftar Pengguna Unit");
			$excel->setActiveSheetIndex(0);

			// Proses file excel
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment; filename="Laporan Daftar Pengguna Biasa.xlsx"');

			// Set nama file excel nya
			header('Cache-Control: max-age=0');
			$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
			$write->save('php://output');
		} else {
			redirect(base_url());
		}
	}
}
