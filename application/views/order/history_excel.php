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
$objPHPExcel->getActiveSheet()->setCellValue("B2", "Laporan Riwayat Layanan Bantu Cabang".stripslashes($cabang));
$objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setSize(20);
$objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->setCellValue("B3", "Periode Tanggal : ". date_format(date_create($tanggal_awal), 'd F Y') ." sampai dengan ".date_format(date_create($tanggal_akhir), 'd F Y'));

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
            ;

// Header style
$objPHPExcel->getActiveSheet()->getStyle('B4:M4')->applyFromArray(
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
$nama_cabang = "";

// Zebra
$zebra = "ya";

/* Content Here */
foreach ($data_order_selesai->result_array() as $dl) {
	$no++;
	$top_limit++;

  // Set nama cabang
  if ($nama_cabang=="") {
    $nama_cabang = str_replace(' ', '_', $dl['nama_cabang']);
  }

	// Content style
	$objPHPExcel->getActiveSheet()->getStyle('B'.$top_limit.':M'.$top_limit)->applyFromArray(
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
		if ($top_limit%2==1) {
			$objPHPExcel->getActiveSheet()->getStyle('B'.$top_limit.':M'.$top_limit)->applyFromArray(
				array(
					'fill' => array(
					'type'  => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('argb' => 'e1eaea')
					)
				)
			);
		}
	}

	// Content
	$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue("B".$top_limit, $no)
            ->setCellValue("C".$top_limit, $dl['kode'])
            ->setCellValue("D".$top_limit, date_format(date_create($dl["tanggal"]), 'd M Y H:i:s'))
						->setCellValue("E".$top_limit, $dl['nama_regional'])
						->setCellValue("F".$top_limit, $dl['first_name']. " " .$dl['last_name'])
						->setCellValue("G".$top_limit, $dl['nama_konsumen'])
						->setCellValue("H".$top_limit, $dl['hp_konsumen'])
						->setCellValue("I".$top_limit, $dl['alamat_lokasi'])
						->setCellValue("J".$top_limit, $dl['motor'])
						->setCellValue("K".$top_limit, $dl['nomor_polisi'])
						->setCellValue("L".$top_limit, $dl['nama_jenis_velg'])
						->setCellValue("M".$top_limit, $dl['sumber_info'])
            ;
	/* Content Here */
}


// Wrap it
$objPHPExcel->getActiveSheet()->getStyle('B4:M'.$top_limit)->getAlignment()->setWrapText(true);
// Set Vertical Align to TOP!
$objPHPExcel->getActiveSheet()->getStyle('B4:M'.$top_limit)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);

$objPHPExcel->getActiveSheet()->setCellValue("B2", "Riwayat layanan bantu cabang : ".str_replace("_", " ", $nama_cabang));


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

ob_clean();
// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Laporan_Riwayat_LB_'.$nama_cabang. "_". date_format(date_create($tanggal_awal), 'd_F_Y') ."_sd_".date_format(date_create($tanggal_akhir), 'd_F_Y').'.xlsx"');
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
