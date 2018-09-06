<?php /** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Asia/Jakarta');

if (PHP_SAPI == 'cli')
	die('This report should only be run from a Web Browser');

// Include PHPExcel
require_once 'assets/plugins/phpexcel/PHPExcel.php';

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("anoerman")
	->setLastModifiedBy("anoerman")
	->setTitle("Laporan Riwayat Layanan Bantu")
	->setSubject("Laporan Riwayat Layanan Bantu")
	->setDescription("Menampilkan laporan layanan bantu berdasarkan kriteria pilihan")
	->setKeywords("layanan bantu layanan-bantu lb digital marketing planetban planet ban report it php codeigniter");

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Layanan Bantu');

// Header Title
$objPHPExcel->getActiveSheet()->setCellValue("B2", "Laporan Riwayat Layanan Bantu Cabang ".stripslashes($nama_cabang));
$objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setSize(20);
$objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->setCellValue("B3", "Data order layanan bantu selesai. Periode Tanggal : ". date_format(date_create($tanggal_awal), 'd F Y') ." sampai dengan ".date_format(date_create($tanggal_akhir), 'd F Y'));

// Height
$objPHPExcel->getActiveSheet()->getRowDimension(3)->setRowHeight(30);
$objPHPExcel->getActiveSheet()->getRowDimension(4)->setRowHeight(30);

// Width
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(35);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(40);
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(20);

// Value
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B4', 'No')
            ->setCellValue('C4', 'Kode')
            ->setCellValue('D4', 'Tanggal')
            ->setCellValue('E4', 'Regional')
            ->setCellValue('F4', 'Toko')
            ->setCellValue('G4', 'Nama Konsumen')
            ->setCellValue('H4', 'HP Konsumen')
            ->setCellValue('I4', 'Alamat Lokasi')
            ->setCellValue('J4', 'Motor')
            ->setCellValue('K4', 'Nomor Polisi')
            ->setCellValue('L4', 'Jenis Velg')
            ->setCellValue('M4', 'Sumber Info')
            ->setCellValue('N4', 'Produk')
            ->setCellValue('O4', 'Harga')
            ->setCellValue('P4', 'Petugas LB')
            ->setCellValue('Q4', 'Keterangan')
            ->setCellValue('R4', 'Info Ubah Data')
            ->setCellValue('S4', 'Info Pembatalan')
            ->setCellValue('T4', 'Lead Time 1 (Menit)')
            ->setCellValue('U4', 'Lead Time 2 (Menit)')
            ;

// Header style
$objPHPExcel->getActiveSheet()->getStyle('B4:U4')->applyFromArray(
	array(
		'fill' => array(
			'type'  => PHPExcel_Style_Fill::FILL_SOLID,
			'color' => array('argb' => '367fa9')
		),
    'font'  => array(
      'bold'  => true,
      'color' => array('rgb' => 'FFFFFF')
    ),
		'borders' => array(
			'top'    => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
			'left'   => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
			'right'  => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
			'bottom' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM)
		)
	)
);

// Top Limit
$top_limit = 4;

// Isi
$no          = 0;

// Zebra
$zebra = "ya";

/* Content Here */
foreach ($data_order_selesai->result_array() as $dl) {
	$no++;
	$top_limit++;
	// Set batas atas dan bawah dari baris
	$top_limit1 = $top_limit;
	$top_limit2 = $top_limit;

	// Content
	$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue("B".$top_limit, $no)
    ->setCellValue("C".$top_limit, $dl['kode'])
    // ->setCellValue("D".$top_limit, date_format(date_create($dl["tanggal"]), 'd M Y H:i:s'))
    ->setCellValue("D".$top_limit, date_create($dl["tanggal"]))
		->setCellValue("E".$top_limit, $dl['nama_regional'])
		->setCellValue("F".$top_limit, $dl['first_name']. " " .$dl['last_name'])
		->setCellValue("G".$top_limit, $dl['nama_konsumen'])
		->setCellValue("H".$top_limit, $dl['hp_konsumen'])
		->setCellValue("I".$top_limit, $dl['alamat_lokasi'])
		->setCellValue("J".$top_limit, $dl['motor'])
		->setCellValue("K".$top_limit, $dl['nomor_polisi'])
		->setCellValue("L".$top_limit, $dl['nama_jenis_velg'])
		->setCellValue("M".$top_limit, $dl['sumber_info'])
		->setCellValue("P".$top_limit, $dl['petugas'])
		->setCellValue("Q".$top_limit, $dl['keterangan'])
  ;

	// ===========================================================================

	// Ambil  keterangan ubah data
	$ket_ubah = "";
	$data_ubah = $order_model->get_order_ubah_by_kode($dl["kode"]);
	foreach ($data_ubah->result() as $dubah) {
		$ket_ubah = $dubah->keterangan . "\r";
		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue("R".$top_limit, $ket_ubah)
	  ;
	}

	// ===========================================================================

	// Ambil keterangan batal
	$ket_batal = "";
	$data_batal = $order_model->get_order_batal_by_kode($dl["kode"]);
	foreach ($data_batal->result() as $dbatal) {
		$ket_batal = $dbatal->keterangan . "\r";
		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue("S".$top_limit, $ket_batal)
		;
	}

	// ===========================================================================

	// Ambil lead time dari lb status
	$os1 = "";
	$os3 = "";
	$os4 = "";
	$lt1 = 0;
	$lt2 = 0;
	$data_status = $order_model->get_order_status_by_kode($dl["kode"]);
	foreach ($data_status->result() as $dstatus) {
		if ($dstatus->status == 1) {
			$os1 = strtotime($dstatus->created_on);
		}
		elseif ($dstatus->status == 3) {
			$os3 = strtotime($dstatus->created_on);
		}
		elseif ($dstatus->status == 4) {
			$os4 = strtotime($dstatus->created_on);
		}
	}

	// Hitung lead time 1
	// Order dibuat (1) -> Order diterima (3)
	$lt1 = $os3 - $os1;
	$lt1 = round($lt1/60);
	// $lt1 = number_format($lt1/60, 0, ",", ".");
	if ($os3=="") {
		$lt1 = 0;
	}

	// Hitung lead time 2
	// Order diterima (3) -> Petugas sampai lokasi (4)
	$lt2 = $os4 - $os3;
	$lt2 = round($lt2/60);
	// $lt2 = number_format($lt2/60, 0, ",", ".");
	if ($os4=="") {
		$lt2 = 0;
	}

	// Set lead time
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue("T".$top_limit, $lt1)
	->setCellValue("U".$top_limit, $lt2)
	;

	// ===========================================================================

	// Ambil data Produk
	$data_detail = $order_model->get_order_detail_aktual_by_kode($dl['kode']);
	foreach ($data_detail->result() as $ddetail) {
		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue("N".$top_limit, $ddetail->produk)
			->setCellValue("O".$top_limit, $ddetail->harga)
	  ;
		$top_limit++;
		$top_limit2 = $top_limit;
	}

	// ===========================================================================

	// Content style
	$objPHPExcel->getActiveSheet()->getStyle('B'.$top_limit1.':U'.$top_limit2)->applyFromArray(
		array(
			'borders' => array(
				'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN),
				'left'   => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
				'right'  => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
				'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
			)
		)
	);

	// Set zebra color (odds number)
	if ($zebra=="ya") {
		if ($no%2==1) {
			$objPHPExcel->getActiveSheet()->getStyle('B'.$top_limit1.':U'.$top_limit2)->applyFromArray(
				array(
					'fill' => array(
					'type'  => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('argb' => 'e1eaea')
					)
				)
			);
		}
	}

	/* Content Here */
}

// Reset nomor
$info_limit = $top_limit+4;
$top_limit  = $top_limit+5;
$no         = 0;

// =========================================================================== //

// Value
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B'.$top_limit, 'No')
            ->setCellValue('C'.$top_limit, 'Kode')
            ->setCellValue('D'.$top_limit, 'Tanggal')
            ->setCellValue('E'.$top_limit, 'Regional')
            ->setCellValue('F'.$top_limit, 'Toko')
            ->setCellValue('G'.$top_limit, 'Nama Konsumen')
            ->setCellValue('H'.$top_limit, 'HP Konsumen')
            ->setCellValue('I'.$top_limit, 'Alamat Lokasi')
            ->setCellValue('J'.$top_limit, 'Motor')
            ->setCellValue('K'.$top_limit, 'Nomor Polisi')
            ->setCellValue('L'.$top_limit, 'Jenis Velg')
            ->setCellValue('M'.$top_limit, 'Sumber Info')
            ->setCellValue('N'.$top_limit, 'Produk')
            ->setCellValue('O'.$top_limit, 'Harga')
            ->setCellValue('P'.$top_limit, 'Petugas LB')
            ->setCellValue('Q'.$top_limit, 'Keterangan')
            ->setCellValue('R'.$top_limit, 'Info Ubah Data')
            ->setCellValue('S'.$top_limit, 'Info Pembatalan')
            ->setCellValue('T'.$top_limit, 'Lead Time 1 (Menit)')
            ->setCellValue('U'.$top_limit, 'Lead Time 2 (Menit)')
            ;

// Header style
$objPHPExcel->getActiveSheet()->getStyle('B'.($top_limit).':U'.($top_limit))->applyFromArray(
	array(
		'fill' => array(
			'type'  => PHPExcel_Style_Fill::FILL_SOLID,
			'color' => array('argb' => '367fa9')
		),
    'font'  => array(
      'bold'  => true,
      'color' => array('rgb' => 'FFFFFF')
    ),
		'borders' => array(
			'top'    => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
			'left'   => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
			'right'  => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
			'bottom' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM)
		)
	)
);

$objPHPExcel->getActiveSheet()->setCellValue("B".$info_limit, "Data order layanan bantu yang dibatalkan");

// Height
$objPHPExcel->getActiveSheet()->getRowDimension($info_limit)->setRowHeight(30);
$objPHPExcel->getActiveSheet()->getRowDimension($top_limit)->setRowHeight(30);

/* Content Here 2 */
foreach ($data_order_batal->result_array() as $dlbtl) {
	$no++;
	$top_limit++;
	// Set batas atas dan bawah dari baris
	$top_limit1 = $top_limit;
	$top_limit2 = $top_limit;

	// Content
	$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue("B".$top_limit, $no)
    ->setCellValue("C".$top_limit, $dlbtl['kode'])
    // ->setCellValue("D".$top_limit, date_format(date_create($dlbtl["tanggal"]), 'd M Y H:i:s'))
    ->setCellValue("D".$top_limit, date_create($dlbtl["tanggal"]))
		->setCellValue("E".$top_limit, $dlbtl['nama_regional'])
		->setCellValue("F".$top_limit, $dlbtl['first_name']. " " .$dlbtl['last_name'])
		->setCellValue("G".$top_limit, $dlbtl['nama_konsumen'])
		->setCellValue("H".$top_limit, $dlbtl['hp_konsumen'])
		->setCellValue("I".$top_limit, $dlbtl['alamat_lokasi'])
		->setCellValue("J".$top_limit, $dlbtl['motor'])
		->setCellValue("K".$top_limit, $dlbtl['nomor_polisi'])
		->setCellValue("L".$top_limit, $dlbtl['nama_jenis_velg'])
		->setCellValue("M".$top_limit, $dlbtl['sumber_info'])
		->setCellValue("P".$top_limit, $dlbtl['petugas'])
		->setCellValue("Q".$top_limit, $dlbtl['keterangan'])
  ;

	// ===========================================================================

	// Ambil  keterangan ubah data
	$ket_ubah = "";
	$data_ubah = $order_model->get_order_ubah_by_kode($dlbtl["kode"]);
	foreach ($data_ubah->result() as $dubah) {
		$ket_ubah = $dubah->keterangan . "\r";
		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue("R".$top_limit, $ket_ubah)
	  ;
	}

	// ===========================================================================

	// Ambil keterangan batal
	$ket_batal = "";
	$data_batal = $order_model->get_order_batal_by_kode($dlbtl["kode"]);
	foreach ($data_batal->result() as $dbatal) {
		$ket_batal = $dbatal->keterangan . "\r";
		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue("S".$top_limit, $ket_batal)
		;
	}

	// ===========================================================================

	// Ambil lead time dari lb status
	$os1 = "";
	$os3 = "";
	$os4 = "";
	$lt1 = 0;
	$lt2 = 0;
	$data_status = $order_model->get_order_status_by_kode($dlbtl["kode"]);
	foreach ($data_status->result() as $dstatus) {
		if ($dstatus->status == 1) {
			$os1 = strtotime($dstatus->created_on);
		}
		elseif ($dstatus->status == 3) {
			$os3 = strtotime($dstatus->created_on);
		}
		elseif ($dstatus->status == 4) {
			$os4 = strtotime($dstatus->created_on);
		}
	}

	// Hitung lead time 1
	// Order dibuat (1) -> Order diterima (3)
	$lt1 = $os3 - $os1;
	$lt1 = round($lt1/60);
	// $lt1 = number_format($lt1/60, 0, ",", ".");
	if ($os3=="") {
		$lt1 = 0;
	}

	// Hitung lead time 2
	// Order diterima (3) -> Petugas sampai lokasi (4)
	$lt2 = $os4 - $os3;
	$lt2 = round($lt2/60);
	// $lt2 = number_format($lt2/60, 0, ",", ".");
	if ($os4=="") {
		$lt2 = 0;
	}

	// Set lead time
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue("T".$top_limit, $lt1)
	->setCellValue("U".$top_limit, $lt2)
	;

	// ===========================================================================

	// Ambil data Produk
	$data_detail = $order_model->get_order_detail_aktual_by_kode($dlbtl['kode']);
	foreach ($data_detail->result() as $ddetail) {
		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue("N".$top_limit, $ddetail->produk)
			->setCellValue("O".$top_limit, $ddetail->harga)
	  ;
		$top_limit++;
		$top_limit2 = $top_limit;
	}

	// ===========================================================================

	// Content style
	$objPHPExcel->getActiveSheet()->getStyle('B'.$top_limit1.':U'.$top_limit2)->applyFromArray(
		array(
			'borders' => array(
				'top'    => array('style' => PHPExcel_Style_Border::BORDER_THIN),
				'left'   => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
				'right'  => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
				'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
			)
		)
	);

	// Set zebra color (odds number)
	if ($zebra=="ya") {
		if ($no%2==1) {
			$objPHPExcel->getActiveSheet()->getStyle('B'.$top_limit1.':U'.$top_limit2)->applyFromArray(
				array(
					'fill' => array(
					'type'  => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('argb' => 'e1eaea')
					)
				)
			);
		}
	}

	/* Content Here */
}

// Wrap it
$objPHPExcel->getActiveSheet()->getStyle('B4:U'.$top_limit)->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('B'.$info_limit)->getAlignment()->setWrapText(false);
// Set Vertical Align to TOP!
$objPHPExcel->getActiveSheet()->getStyle('B3:U'.$top_limit)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);

$objPHPExcel->getActiveSheet()->setCellValue("B2", "Riwayat layanan bantu cabang : ".$nama_cabang);


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

ob_clean();
// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Laporan_Riwayat_LB_'.str_replace(" ", "_", $nama_cabang). "_". date_format(date_create($tanggal_awal), 'd_F_Y') ."_sd_".date_format(date_create($tanggal_akhir), 'd_F_Y').'.xlsx"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;


?>
