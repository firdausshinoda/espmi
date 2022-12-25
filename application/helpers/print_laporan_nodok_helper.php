<?php
define('FPDF_FONTPATH',APPPATH .'plugins/fpdf/font/');
require(APPPATH .'plugins/fpdf/fpdf.php');

class Print_Laporan_Nodok extends FPDF {
	protected $B = 0;
	protected $I = 0;
	protected $U = 0;
	protected $HREF = '';

	function __construct(){
		parent::__construct();
		$ci =& get_instance();
	}

	function kop(){
		$this->image('assets/dist/img/logo.png',15,10,30,30);
		$this->cell(0,5,"",0,1);
		$this->Cell(3);
		$this->SetFont('Times','','14');
		$this->Cell(0,7,"Yayasan Pendidikan Harapan Bersama",0,1,'C');
		$this->SetFont('Times','B','24');
		$this->SetTextColor(255,0,0);
		$this->Cell(82,7,"PoliTeknik",0,0,'R');
		$this->SetTextColor(25,25,112);
		$this->Cell(0,7,"Harapan Bersama",0,1,'L');
		$this->Cell(3);
		$this->SetFont('Times','','10');
		$this->SetTextColor(0,0,0);
		$this->Cell(0,6,"Kampus I : Jln. Mataram No. 9 Tegal 52142 Telp. 0283-352000 Fax. 0283-353353",0,1,'C');
		$this->Cell(0,5,"website : www.poltektegal.ac.id",0,1,'C');
		$this->SetLineWidth(1);
		$this->Line(10,42,200,42);
		$this->SetLineWidth(0);
		$this->Line(10,41,200,41);
	}

	function isi($data){
		$this->Ln();
		$this->Cell(1);
		$this->SetFont('Times','','12');
		$this->cell(0,5,"",0,1);
		$this->Cell(0,0,"Tanggal : ".setTglIndo(get_date()),0,1,'R',false);
		$this->cell(0,10,"",0,1);
		$this->Cell(1);
		$this->SetFont('Times','','12');
		$this->cell(0,5,"Perihal            : Laporan Daftar Nomor Dokumen",0,1);

		$this->cell(0,5,"",0,1);
		$this->setFont('times','B',12);
		$this->SetFillColor(192,192,192);
		$this->SetTextColor(0,0,0);
		$this->Cell(1);
		$this->Cell(15,8,"No",1,0,'C',true);
		$this->Cell(50,8,"Nomor Dokumen",1,0,'C',true);
		$this->Cell(50,8,"Perihal Dokumen",1,0,'C',true);
		$this->Cell(35,8,"Jenis Dokumen",1,0,'C',true);
		$this->Cell(40,8,"Tanggal Dibuat",1,0,'C',true);

		$this->Ln();
		$no=1;
		$this->setFont('times','',12);
		if ($data->num_rows() > 0){
			$this->SetWidths(array(15,50,50,35,40));$this->SetAligns(array('C','L','L','L','L'));
			foreach ($data->result() as $it){
				$this->Row(array($no++,$it->nomor_dokumen,$it->perihal_dokumen,$it->jenis_dokumen,setTglIndo($it->cdate)));
			}
		} else {
			$this->SetWidths(array(190));$this->SetAligns(array('C'));$this->Row(array("Tidak Ada Data"));
		}
	}

	//--------------------------------------------------------------------------------------------------------------------

	function SetWidths($w)
	{
		//Set the array of column widths
		$this->widths=$w;
	}

	function SetAligns($a)
	{
		//Set the array of column alignments
		$this->aligns=$a;
	}

	function Row($data)
	{
		//Calculate the height of the row
		$nb=0;
		for($i=0;$i<count($data);$i++)
			$nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
		$h=5*$nb;
		//Issue a page break first if needed
		$this->CheckPageBreak($h);
		$this->Cell(1);
		//Draw the cells of the row
		for($i=0;$i<count($data);$i++)
		{
			$w=$this->widths[$i];
			$a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
			//Save the current position
			$x=$this->GetX();
			$y=$this->GetY();
			//Draw the border
			$this->Rect($x,$y,$w,$h);
			//Print the text
			$this->MultiCell($w,5,$data[$i],0,$a);
			//Put the position to the right of the cell
			$this->SetXY($x+$w,$y);
		}
		//Go to the next line
		$this->Ln($h);
	}

	function CheckPageBreak($h)
	{
		//If the height h would cause an overflow, add a new page immediately
		if($this->GetY()+$h>$this->PageBreakTrigger)
			$this->AddPage($this->CurOrientation);
	}

	function NbLines($w,$txt)
	{
		//Computes the number of lines a MultiCell of width w will take
		$cw=&$this->CurrentFont['cw'];
		if($w==0)
			$w=$this->w-$this->rMargin-$this->x;
		$wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
		$s=str_replace("\r",'',$txt);
		$nb=strlen($s);
		if($nb>0 and $s[$nb-1]=="\n")
			$nb--;
		$sep=-1;
		$i=0;
		$j=0;
		$l=0;
		$nl=1;
		while($i<$nb)
		{
			$c=$s[$i];
			if($c=="\n")
			{
				$i++;
				$sep=-1;
				$j=$i;
				$l=0;
				$nl++;
				continue;
			}
			if($c==' ')
				$sep=$i;
			$l+=$cw[$c];
			if($l>$wmax)
			{
				if($sep==-1)
				{
					if($i==$j)
						$i++;
				}
				else
					$i=$sep+1;
				$sep=-1;
				$j=$i;
				$l=0;
				$nl++;
			}
			else
				$i++;
		}
		return $nl;
	}
}
