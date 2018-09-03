<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*	Order Controller
*
*	@author   Noerman Agustiyan
* 				  noerman.agustiyan@gmail.com
*           @anoerman
*
*	@link 		https://github.com/anoerman
*		 		    https://gitlab.com/anoerman
*
*	Controller semua kegiatan yang terjadi pada halaman order
*	Dapat diakses oleh user group admin dan cs
*
*/
class Order extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		// set error delimeters
		$this->form_validation->set_error_delimiters(
			$this->config->item('error_start_delimiter', 'ion_auth'),
			$this->config->item('error_end_delimiter', 'ion_auth')
		);

		// model
		$this->load->model(
			array(
				'profile_model',
				'order_model',
				'toko_model',
				'jenis_velg_model',
				'cabang_model',
				'regional_model',
			)
		);

		// default datas
		// used in every pages
		if ($this->ion_auth->logged_in()) {
			// user detail
			$loggedinuser = $this->ion_auth->user()->row();
			$this->data['username']       = $loggedinuser->username;
			$this->data['user_full_name'] = $loggedinuser->first_name . " " . $loggedinuser->last_name;
			$this->data['user_cabang']    = $loggedinuser->cabang_id;
			$this->data['user_photo']     = $this->profile_model->get_user_photo($loggedinuser->username)->row();
		}

	}

	/**
	*	Index Page for this controller.
	*
	*	@return 	void
	*
	*/
	public function index()
	{
		// Jika tidak login, kembalikan ke halaman utama
		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login', 'refresh');
		}
		// Jika login
		else
		{
			if ($this->ion_auth->in_group('toko')) {
				redirect('order/data_list', 'refresh');
			}
			// input validation rules
			$this->form_validation->set_rules('nama_konsumen', 'Nama Konsumen', 'alpha_numeric_spaces|trim|required');
			$this->form_validation->set_rules('hp_konsumen', 'HP Konsumen', 'numeric|trim|required|min_length[9]|max_length[14]');
			$this->form_validation->set_rules('alamat_lokasi', 'Alamat Lokasi', 'trim|strip_tags|addslashes|required');
			$this->form_validation->set_rules('sumber_info', 'Sumber Info', 'trim|strip_tags|addslashes');
			$this->form_validation->set_rules('cabang', 'Cabang', 'trim|required');
			$this->form_validation->set_rules('regional_id', 'Regional', 'trim|required');
			$this->form_validation->set_rules('toko', 'Toko', 'trim|required');
			$this->form_validation->set_rules('motor', 'Nama Motor', 'trim|addslashes');
			$this->form_validation->set_rules('nomor_polisi', 'Nomor Polisi', 'alpha_numeric_spaces|trim');
			$this->form_validation->set_rules('jenis_velg', 'Jenis Velg', 'alpha_numeric_spaces|trim');
			$this->form_validation->set_rules('produk[]', 'Produk', 'addslashes|trim');
			$this->form_validation->set_rules('harga[]', 'Harga', 'numeric|addslashes|trim');

			// check if there's valid input
			if (isset($_POST) && !empty($_POST)) {
				// validation run
				if ($this->form_validation->run() === TRUE) {
					// Set kode (check if there's duplicate code)
					$kode     = "LB-".now();
					while ($this->order_model->check_code($kode) == FALSE) {
						$kode = "LB-".now();
					}

					// Set status
					$status = '1';
					if ($this->input->post('toko')=="") {
						$status = '2';
					}

					// Array special char to be replaced
					$rpl = array (".", ",", " ", "-", "+");

					// Order data array
					$data = array(
						'kode'          => $kode,
						'tanggal'       => date('Y-m-d H:i:s', now()),
						'nama_konsumen' => $this->input->post('nama_konsumen'),
						'hp_konsumen'   => str_replace($rpl, "", $this->input->post('hp_konsumen')),
						'alamat_lokasi' => $this->input->post('alamat_lokasi'),
						'motor'         => $this->input->post('motor'),
						'nomor_polisi'  => $this->input->post('nomor_polisi'),
						'jenis_velg'    => $this->input->post('jenis_velg'),
						'sumber_info'   => $this->input->post('sumber_info'),
						'cabang'        => $this->input->post('cabang'),
						'regional'      => $this->input->post('regional_id'),
						'toko'          => $this->input->post('toko'),
						'status'        => $status,
						'hapus'         => '0',
					);

					// Order detail data array
					$data_detail = array();
					$num         = 0;
					for ($i=0; $i < count($this->input->post('produk')); $i++) {
						// Hanya ambil array dengan data produk dan harga yang terisi data
						if (!empty($this->input->post('produk')[$i]) && !empty($this->input->post('harga')[$i])) {
							$data_detail[$num] = array(
								'lb_kode'    => $kode,
								'produk'     => $this->input->post('produk')[$i],
								'harga'      => str_replace($rpl, "", $this->input->post('harga')[$i]),
								'aktual'     => '0',
								'keterangan' => '',
							);
							$num++;
						}
					}

					// var_dump($data_detail);
					// exit;

					// check to see if we are inserting the data
					if ($this->order_model->insert_data($data)) {
						$lb_id = $this->db->insert_id();
						// Insert detail data
						if ($this->order_model->insert_data_detail($lb_id, $data_detail)) {
							// Insert status
							$data_status = array(
								'lb_id'   => $lb_id,
								'lb_kode' => $kode,
								'status'  => $status,
							);
							$this->order_model->insert_data_status($data_status);

							// Set message
							$this->session->set_flashdata('message',
								$this->config->item('message_start_delimiter', 'ion_auth')
								."Pesanan sudah berhasil disimpan!".
								$this->config->item('message_end_delimiter', 'ion_auth')
							);
						}
						else {
							// Fail to save the detail
							$this->session->set_flashdata('message',
								$this->config->item('error_start_delimiter', 'ion_auth')
								."Detail Pesanan gagal disimpan!".
								$this->config->item('error_end_delimiter', 'ion_auth')
							);
						}
					}
					else {
						// Set message
						$this->session->set_flashdata('message',
							$this->config->item('error_start_delimiter', 'ion_auth')
							."Data pesanan gagal disimpan!".
							$this->config->item('error_end_delimiter', 'ion_auth')
						);
					}
					redirect('order', 'refresh');
				}

			}

			// set the flash data error message if there is one
			$this->data['message']    = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->data['cabang']     = $this->cabang_model->get_cabang("", "1");
			$this->data['toko']       = $this->toko_model->get_toko_aktif($this->data['user_cabang']);
			$this->data['last_query'] = $this->db->last_query();
			$this->data['jenis_velg'] = $this->jenis_velg_model->get_jenis_velg();

			$this->load->view('partials/_alte_header', $this->data);
			$this->load->view('partials/_alte_menu');
			$this->load->view('order/index');
			$this->load->view('partials/_alte_footer');
			$this->load->view('order/js');
		}
	}

	/**
	*	Data produk
	*	Sebagai sumber data untuk autocomplete
	*
	*	@return 	string
	*
	*/
	public function data_produk()
	{
		// Jika tidak login, kembalikan ke halaman utama
		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login', 'refresh');
		}

		$term            = trim(strip_tags($this->input->get('query')));
		$result          = array();
		$result['query'] = $term;

		if ($term != "" && $term != " ") {
			// Query
			$this->db->select('produk');
			$this->db->group_by('produk');
			$this->db->like('produk', $term);
			$this->db->limit('2');
			$datas = $this->db->get('master_auto_produk');
			if (count($datas->result()) > 0) {
				foreach ($datas->result() as $data) {
					$result['suggestions'][] = htmlentities(stripslashes($data->produk));
				}
			}
			else {
				$result['suggestions'] = array();
			}
		}
		else {
			$result['suggestions'] = array();
		}
		echo json_encode($result);
	}

	/**
	*	Data toko
	*	Sebagai sumber data untuk pilihan toko berdasarkan regional
	*
	*	@return 	string
	*
	*/
	public function data_toko()
	{
		// Jika tidak login, kembalikan ke halaman utama
		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login', 'refresh');
		}

		$regional = $this->input->get('regional');

		$result = '<select name="toko" id="toko" class="form-control select2" style="width:100%">';
		if ($regional != "" && $regional != " ") {
			$datas = $this->toko_model->get_toko_by_regional($regional);
			if (count($datas->result())>0) {
				foreach ($datas->result() as $data) {
					$result .= "<option value=".$data->username.">".$data->first_name . " " . $data->last_name."</option>";
				}
			}
		}
		// $result .= '<option value="">Pesanan Terbuka</option>';
		$result .= '</select>';

		echo $result;
	}

	/**
	*	Daftar layanan
	*	Tampilan pada CS
	*
	*	@return 	void
	*
	*/
	public function data_list($cabang="0")
	{
		// Jika tidak login, kembalikan ke halaman utama
		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login', 'refresh');
		}
		// Jika login
		else
		{
			// Jika toko, tampilkan order aktif
			if ($this->ion_auth->in_group('toko')) {
				$this->my_order();
			}
			// Else, tampilkan semua order
			else {
				// Set cabang datas
				$this->data['cabang_list']  = $this->cabang_model->get_cabang("", "1");
				// Cabang yang ingin dilihat detail ordernya
				$this->data['curr_cabang']  = $cabang;
				// Waktu refresh halaman dalam milisecond (standar 30 detik)
				$this->data['time_refresh'] = 30000;
				// set the flash data error message if there is one
				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

				$this->load->view('partials/_alte_header', $this->data);
				$this->load->view('partials/_alte_menu');
				$this->load->view('order/list_container');
				$this->load->view('partials/_alte_footer');
				$this->load->view('order/js');
				$this->load->view('order/auto_reload_js');
			}

		}
	}

	/**
	*	Data dinamis
	*	Data yang diambil via ajax call per interval
	*
	*	@return 	void
	*
	*/
	public function data_dinamis($cabang)
	{
		// Jika tidak login, kembalikan ke halaman utama
		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login', 'refresh');
		}
		// Jika login
		else
		{
			// Jika toko, tampilkan order aktif
			if ($this->ion_auth->in_group('toko')) {
				$this->my_order();
			}
			// Else, tampilkan semua order
			else {
				$this->data['data_order_baru']       = $this->order_model->get_order_cabang_by_status($cabang, 1);
				$this->data['data_order_buka']       = $this->order_model->get_order_cabang_by_status($cabang, 2);
				$this->data['data_order_jalan']      = $this->order_model->get_order_cabang_by_status($cabang, 3);
				$this->data['data_order_sampai']     = $this->order_model->get_order_cabang_by_status($cabang, 4);
				$this->data['data_order_konfirmasi'] = $this->order_model->get_order_cabang_by_status($cabang, 5);
				$this->data['total_semua_data']      = count($this->data['data_order_baru']->result()) +
					count($this->data['data_order_buka']->result()) +
					count($this->data['data_order_jalan']->result()) +
					count($this->data['data_order_sampai']->result()) +
					count($this->data['data_order_konfirmasi']->result());
				// $this->data['last_query'] = $this->db->last_query();

				$this->load->view('order/dynamic_data', $this->data);
			}

		}
	}

	/**
	*	Daftar layanan
	*	Tampilan pada toko
	*
	*	@return 	void
	*
	*/
	public function my_order()
	{
		// Jika tidak login, kembalikan ke halaman utama
		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login', 'refresh');
		}
		// Jika login
		else
		{
			// Jika bukan toko, tampilkan semua data order
			if (!$this->ion_auth->in_group('toko')) {
				redirect('order/data_list', 'refresh');
			}

			// set the flash data error message if there is one
			$toko                  = $this->data['username'];
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			// Cek jika toko sudah punya order yang statusnya belum selesai
			$order_aktif_toko = $this->order_model->get_order_toko_aktif($toko);
			// Jika ada, tampilkan detail ordernya.
			if (count($order_aktif_toko->result())>0) {
				// Ambil kode order aktif
				$kode = "";
				foreach ($order_aktif_toko->result() as $data) {
					$kode = $data->kode;
				}

				// set the flash data error message if there is one
				$this->data['message']     = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
				$this->data['kode']        = $kode;
				$this->data['data_header'] = $this->order_model->get_order_by_kode($kode);
				$this->data['data_detail'] = $this->order_model->get_order_detail_by_kode($kode);

				$this->load->view('partials/_alte_header', $this->data);
				$this->load->view('partials/_alte_menu');
				$this->load->view('order/detail');
				$this->load->view('partials/_alte_footer');
				$this->load->view('order/js');
			}
			// Jika tidak ada, tampilkan order terbuka.
			else {
				$this->data['data_order_buka'] = $this->order_model->get_order_toko_by_status("", 2);
				// $this->data['last_query'] = $this->db->last_query();

				$this->load->view('partials/_alte_header', $this->data);
				$this->load->view('partials/_alte_menu');
				$this->load->view('order/list_view_toko');
				$this->load->view('partials/_alte_footer');
				$this->load->view('order/js');
			}

		}
	}

	/**
	*	Riwayat order
	*
	*	@param 		string
	*	@param 		string
	*	@param 		string
	*	@return 	void
	*
	*/
	public function history($start="", $finish="", $page="1")
	{
		// Jika tidak login, kembalikan ke halaman utama
		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login', 'refresh');
		}
		// Jika login
		else
		{
			// Jika toko, tampilkan order aktif
			if ($this->ion_auth->in_group('toko')) {
				$this->my_order();
			}
			else {
				$this->data['tanggal_awal']       = $start;
				$this->data['tanggal_akhir']      = $finish;
				$this->data['daftar_cabang']      = $this->cabang_model->get_cabang("", "1");
				$this->data['data_order_selesai'] = "";
				if ($start!="" && $finish!="") {
					$this->data['data_order_selesai'] = $this->order_model->get_order_history($start, $finish);

					// Set pagination
					$config['base_url']         = base_url('order/history/'.$start.'/'.$finish);
					$config['use_page_numbers'] = TRUE;
					$config['total_rows']       = count($this->data['data_order_selesai']->result());
					$config['per_page']         = 10;
					$this->pagination->initialize($config);

					// Get datas and limit based on pagination settings
					if ($page=="") { $page = 1; }
					$this->data['data_order_selesai'] = $this->order_model->get_order_history(
						$start,
						$finish,
						$config['per_page'],
						( $page - 1 ) * $config['per_page']
					);
					$this->data['last_query'] = $this->db->last_query();
					$this->data['pagination'] = $this->pagination->create_links();
				}

				// set the flash data error message if there is one
				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

				$this->load->view('partials/_alte_header', $this->data);
				$this->load->view('partials/_alte_menu');
				$this->load->view('order/history');
				$this->load->view('partials/_alte_footer');
				$this->load->view('order/js');
				$this->load->view('order/history_js');
			}

		}
	}

	/**
	*	Data riwayat order
	*
	*	@return 	void
	*
	*/
	public function history_data()
	{
		// Jika tidak login, kembalikan ke halaman utama
		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login', 'refresh');
		}
		// Jika login
		else
		{
			// Jika toko, tampilkan order aktif
			if ($this->ion_auth->in_group('toko')) {
				$this->my_order();
			}
			else {
				// Ambil semua variable
				$start       = $this->input->post('tanggal_awal');
				$finish      = $this->input->post('tanggal_akhir');
				$cabang      = $this->input->post('cabang');
				$regional_id = $this->input->post('regional_id');
				// $regional_id = (!empty($this->input->post('regional_id'))) ? implode($this->input->post('regional_id'), ",") : "";;

				$this->data['tanggal_awal']       = $start;
				$this->data['tanggal_akhir']      = $finish;
				$this->data['cabang']             = $cabang;
				$this->data['regional_id']        = $regional_id;
				$this->data['daftar_cabang']      = $this->cabang_model->get_cabang("", "1");
				$this->data['daftar_regional']    = $this->regional_model->get_regional_by_cabang($cabang);
				$this->data['data_order_selesai'] = "";

				if ($start!="" && $finish!="") {
					$this->data['data_order_selesai'] = $this->order_model->get_order_history(
						$start,
						$finish,
						$cabang,
						$regional_id
					);

					$this->data['last_query'] = $this->db->last_query();
				}

				// set the flash data error message if there is one
				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

				$this->load->view('partials/_alte_header', $this->data);
				$this->load->view('partials/_alte_menu');
				$this->load->view('order/history');
				$this->load->view('partials/_alte_footer');
				$this->load->view('order/js');
				$this->load->view('order/history_js');
			}

		}
	}

	/**
	*	Download data riwayat order
	*
	*	@return 	void
	*
	*/
	public function history_excel()
	{
		// Jika tidak login, kembalikan ke halaman utama
		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login', 'refresh');
		}
		// Jika login
		else
		{
			// Jika toko, tampilkan order aktif
			if ($this->ion_auth->in_group('toko')) {
				$this->my_order();
			}
			else {
				// Ambil semua variable
				$start       = $this->input->post('tanggal_awal');
				$finish      = $this->input->post('tanggal_akhir');
				$cabang      = $this->input->post('cabang');
				$regional_id = $this->input->post('regional_id');

				$this->data['tanggal_awal']  = $start;
				$this->data['tanggal_akhir'] = $finish;
				$this->data['cabang']        = $cabang;
				$this->data['regional_id']   = $regional_id;

				if ($start!="" && $finish!="") {
					$this->data['data_order_selesai'] = $this->order_model->get_order_history(
						$start,
						$finish,
						$cabang,
						$regional_id
					);

					$this->data['last_query'] = $this->db->last_query();
				}

				// set the flash data error message if there is one
				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

				$this->load->view('partials/_alte_header', $this->data);
				$this->load->view('partials/_alte_menu');
				$this->load->view('order/history_excel');
				$this->load->view('partials/_alte_footer');
				$this->load->view('order/js');
				$this->load->view('order/history_js');
			}

		}
	}


	/**
	*	Layanan yang telah selesai
	*	Tampilan pada toko
	*
	*	@param 		string
	*
	*/
	public function completed($page=1)
	{
		// Jika tidak login, kembalikan ke halaman utama
		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login', 'refresh');
		}
		// Jika login
		else
		{
			// Jika bukan toko, tampilkan semua data order
			if (!$this->ion_auth->in_group('toko')) {
				redirect('order/history', 'refresh');
			}

			$toko                       = $this->data['username'];
			$this->data['data_selesai'] = $this->order_model->get_order_toko_selesai($toko);

			// Set pagination
			$config['base_url']         = base_url('order/completed');
			$config['use_page_numbers'] = TRUE;
			$config['total_rows']       = count($this->data['data_selesai']->result());
			$config['per_page']         = 15;
			$this->pagination->initialize($config);

			// Get datas and limit based on pagination settings
			if ($page=="") { $page = 1; }
			$this->data['data_selesai'] = $this->order_model->get_order_toko_selesai($toko,
				$config['per_page'],
				( $page - 1 ) * $config['per_page']
			);
			$this->data['pagination'] = $this->pagination->create_links();

			// set the flash data error message if there is one
			$this->data['message']      = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$this->load->view('partials/_alte_header', $this->data);
			$this->load->view('partials/_alte_menu');
			$this->load->view('order/history_toko');
			$this->load->view('partials/_alte_footer');
			$this->load->view('order/js');
		}
	}

	/**
	*	Proses ubah status order
	*
	*	@param 		string
	*	@return 	void
	*
	*/
	public function proses($kode)
	{
		// Jika tidak login, kembalikan ke halaman utama
		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login', 'refresh');
		}
		// Jika login
		else
		{
			// Ambil data order
			$data_order = $this->order_model->get_order_by_kode($kode);
			foreach ($data_order->result() as $dor) {
				$lb_id  = $dor->id;
				$status = $dor->status;
			}

			// Set array variable
			$datas['lb_id']   = $lb_id;
			$datas['lb_kode'] = $kode;

			// Set status
			if ($status==1) {
				$datas['status'] = $status+2;
			}
			else {
				$datas['status'] = $status+1;
			}

			// Ubah data order
			if ($this->order_model->update_order_status($kode, $datas)) {
				// Set message
				$this->session->set_flashdata('message',
					$this->config->item('message_start_delimiter', 'ion_auth')
					."Pesanan sudah di proses!".
					$this->config->item('message_end_delimiter', 'ion_auth')
				);
			}
			else {
				// Set message
				$this->session->set_flashdata('message',
					$this->config->item('error_start_delimiter', 'ion_auth')
					."Data pesanan gagal di proses!".
					$this->config->item('error_end_delimiter', 'ion_auth')
				);
			}
			// Redirect
			redirect('order/my_order', 'refresh');
		}
	}

	/**
	*	Konfirmasi pesanan dengan aktual barang yang dibutuhkan
	*	Ada kemungkinan perubahan / penambahan data barang
	*	Ada proses upload foto (optional)
	*
	*	@param 		string
	*	@return 	void
	*
	*/
	public function konfirmasi($kode)
	{
		// Jika tidak login, kembalikan ke halaman utama
		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login', 'refresh');
		}
		// Jika login
		else
		{
			// Ambil ID order
			$lb_id = "";
			$data_order = $this->order_model->get_order_by_kode($kode);
			foreach ($data_order->result() as $dor) {
				$lb_id = $dor->id;
				$curr_status = $dor->status;
			}
			// Cek jika kode memang sudah saatnya proses konfirmasi
			// Jika statusnya tidak sama dengan 4, maka redirect ke halaman lain.
			if ($curr_status!=4) {
				redirect('order/my_order', 'refresh');
			}

			// input validation rules
			// $this->form_validation->set_rules('motor', 'Nama Motor', 'trim|addslashes');
			// $this->form_validation->set_rules('nomor_polisi', 'Nomor Polisi', 'alpha_numeric_spaces|trim|required');
			// $this->form_validation->set_rules('jenis_velg', 'Jenis Velg', 'alpha_numeric_spaces|trim');
			$this->form_validation->set_rules('petugas', 'Nama Petugas', 'addslashes|trim|required');
			$this->form_validation->set_rules('keterangan', 'Keterangan', 'addslashes|trim');

			// check if there's valid input
			if (isset($_POST) && !empty($_POST)) {
				// validation run
				if ($this->form_validation->run() === TRUE) {
					// Cek jika upload foto
					$link_foto = "";
					if (!empty($_FILES['foto']['name'])) {
						$config['file_name']     = trim($kode)."_photo";
						$config['upload_path']   = './assets/uploads/images/konfirmasi/';
						$config['allowed_types'] = 'gif|jpg|png';
						$config['max_size']      = 2048;
						$config['overwrite']     = TRUE;
						$this->load->library('upload', $config);
						// fail to upload
						if ( ! $this->upload->do_upload('foto')) {
							// redirect back
							$this->session->set_flashdata('message', array('error' => $this->upload->display_errors()));
							$this->data['kode']        = $kode;
							$this->data['data_header'] = $this->order_model->get_order_by_kode($kode);
							$this->data['data_detail'] = $this->order_model->get_order_detail_by_kode($kode);
							$this->data['jenis_velg']  = $this->jenis_velg_model->get_jenis_velg();

							$this->load->view('partials/_alte_header', $this->data);
							$this->load->view('partials/_alte_menu');
							$this->load->view('order/confirmation');
							$this->load->view('partials/_alte_footer');
							$this->load->view('order/js');
						}
						// upload success, get path and filename
						else {
							$upload_data = $this->upload->data();

							// Proses pembuatan thumbnail
							$config['image_library']  = 'gd2';
							$config['source_image']   = "assets/uploads/images/konfirmasi/".$upload_data['file_name'];
							$config['create_thumb']   = TRUE;
							$config['maintain_ratio'] = TRUE;
							$config['width']          = 260;
							$this->load->library('image_lib', $config);
							if ($this->image_lib->resize()){
								$link_foto = $upload_data['raw_name'] . "_thumb" . $upload_data['file_ext'];
							}
							// Hapus gambar asli?
							// unlink($config['source_image']);
						}
					}

					// Order data array
					$data = array(
						'status'       => '6',
						// 'motor'        => $this->input->post('motor'),
						// 'nomor_polisi' => $this->input->post('nomor_polisi'),
						// 'jenis_velg'   => $this->input->post('jenis_velg'),
						'petugas'      => $this->input->post('petugas'),
						'keterangan'   => $this->input->post('keterangan'),
						'foto'         => $link_foto,
					);

					// Order detail data array
					$data_detail = array();
					$num         = 0;
					for ($i=0; $i < count($this->input->post('produk')); $i++) {
						// Hanya ambil array dengan data produk dan harga yang terisi data
						if (!empty($this->input->post('produk')[$i]) && !empty($this->input->post('harga')[$i])) {
							// Cek duplikat, jika data sudah ada set aktual = 1
							$detail_exists = $this->order_model->set_aktual_data_detail(
								$kode,
								$this->input->post('produk')[$i],
								$this->input->post('harga')[$i]
							);

							// Jika data tidak ada, insert data baru dengan status aktual = 1
							if ($detail_exists == FALSE) {
								$data_detail[$num] = array(
									'lb_kode'    => $kode,
									'keterangan' => 'Data baru setelah konfirmasi',
									'produk'     => $this->input->post('produk')[$i],
									'harga'      => $this->input->post('harga')[$i],
									'aktual'     => '1',
								);
								$num++;
							}

						}
					}

					// check to see if we are updating the data
					if ($this->order_model->update_data($data, $kode)) {
						// Hapus semua data yang tidak di aktualkan
						$data_hapus['hapus']      = '1';
						$data_hapus['keterangan'] = 'Data dihapus karena tidak sesuai dengan request awal';
						$this->order_model->update_data_detail($data_hapus, $kode, '0');

						// Insert data yang baru (jika ada)
						$this->order_model->insert_data_detail($lb_id, $data_detail);

						// Insert status log
						$data_status = array(
							'lb_id'   => $lb_id,
							'lb_kode' => $kode,
							'status'  => '6',
						);

						if ($this->order_model->insert_data_status($data_status)) {
							// Set message
							$this->session->set_flashdata('message',
								$this->config->item('message_start_delimiter', 'ion_auth')
								."Konfirmasi pesanan sudah berhasil disimpan!".
								$this->config->item('message_end_delimiter', 'ion_auth')
							);
						}
						else {
							// Fail to save the detail
							$this->session->set_flashdata('message',
								$this->config->item('error_start_delimiter', 'ion_auth')
								."Konfirmasi Detail Pesanan gagal disimpan!".
								$this->config->item('error_end_delimiter', 'ion_auth')
							);
						}
					}
					else {
						// Set message
						$this->session->set_flashdata('message',
							$this->config->item('error_start_delimiter', 'ion_auth')
							."Konfirmasi Detail Pesanan gagal disimpan!".
							$this->config->item('error_end_delimiter', 'ion_auth')
						);
					}
					redirect('order/data_list', 'refresh');
				}

			}

			// set the flash data error message if there is one
			$this->data['message']     = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->data['kode']        = $kode;
			$this->data['data_header'] = $this->order_model->get_order_by_kode($kode);
			$this->data['data_detail'] = $this->order_model->get_order_detail_by_kode($kode);
			$this->data['jenis_velg']  = $this->jenis_velg_model->get_jenis_velg();

			$this->load->view('partials/_alte_header', $this->data);
			$this->load->view('partials/_alte_menu');
			$this->load->view('order/confirmation');
			$this->load->view('partials/_alte_footer');
			$this->load->view('order/js');
		}
	}

	/**
	*	Batalkan order layanan bantu
	*	Data yang dibatalkan tidak ditampilkan lagi di toko
	*
	*	@param 		string
	*	@return 	void
	*
	*/
	public function batal($kode)
	{
		// Jika tidak login, kembalikan ke halaman utama
		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login', 'refresh');
		}
		// Jika login
		else
		{
			// Ambil data order
			$data_order = $this->order_model->get_order_by_kode($kode);
			foreach ($data_order->result() as $dor) {
				$lb_id  = $dor->id;
				$status = $dor->status;
			}

			// Set array variable
			$datas['lb_id']   = $lb_id;
			$datas['lb_kode'] = $kode;

			// Set status
			$datas['status'] = 7;

			// Validation
			$this->form_validation->set_rules('keterangan_batal', 'Keterangan Batal', 'alpha_numeric_spaces|strip_tags|trim|required');

			// check if there's valid input
			if (isset($_POST) && !empty($_POST)) {
				// validation run
				if ($this->form_validation->run() === TRUE) {

					// Ubah data order + insert status
					if ($this->order_model->update_order_status($kode, $datas)) {
						// Input data pembatalan
						$data_batal = array(
							'lb_id'      => $lb_id,
							'lb_kode'    => $kode,
							'keterangan' => $this->input->post('keterangan_batal'),
						);

						$this->order_model->insert_data_batal($data_batal);

						// Set message
						$this->session->set_flashdata('message',
							$this->config->item('message_start_delimiter', 'ion_auth')
							."Pesanan sudah di proses!".
							$this->config->item('message_end_delimiter', 'ion_auth')
						);
					}
					else {
						// Set message
						$this->session->set_flashdata('message',
							$this->config->item('error_start_delimiter', 'ion_auth')
							."Data pesanan gagal di proses!".
							$this->config->item('error_end_delimiter', 'ion_auth')
						);
					}

				}
			}

			// Redirect
			redirect('order/my_order', 'refresh');
		}
	}


	/**
	*	Ubah data layanan bantu
	*
	*	@param 		string
	*	@return 	void
	*
	*/
	public function edit($kode)
	{
		// Jika tidak login, kembalikan ke halaman utama
		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login', 'refresh');
		}
		// Jika login
		else
		{
			// Jika toko, kembalikan ke order aktif
			if ($this->ion_auth->in_group('toko')) {
				redirect('order/my_order', 'refresh');
			}

			// input validation rules
			$this->form_validation->set_rules('nama_konsumen', 'Nama Konsumen', 'alpha_numeric_spaces|trim|required');
			$this->form_validation->set_rules('hp_konsumen', 'HP Konsumen', 'numeric|trim|required|min_length[9]|max_length[14]');
			$this->form_validation->set_rules('alamat_lokasi', 'Alamat Lokasi', 'trim|strip_tags|addslashes|required');
			$this->form_validation->set_rules('sumber_info', 'Sumber Info', 'trim|strip_tags|addslashes');
			$this->form_validation->set_rules('cabang', 'Cabang', 'trim|required');
			$this->form_validation->set_rules('regional_id', 'Regional', 'trim|required');
			$this->form_validation->set_rules('toko', 'Toko', 'trim|required');
			$this->form_validation->set_rules('motor', 'Nama Motor', 'trim|addslashes|required');
			$this->form_validation->set_rules('nomor_polisi', 'Nomor Polisi', 'alpha_numeric_spaces|trim');
			$this->form_validation->set_rules('jenis_velg', 'Jenis Velg', 'alpha_numeric_spaces|trim');
			$this->form_validation->set_rules('produk[]', 'Produk', 'addslashes|trim');
			$this->form_validation->set_rules('harga[]', 'Harga', 'numeric|addslashes|trim');

			// check if there's valid input
			if (isset($_POST) && !empty($_POST)) {
				// validation run
				if ($this->form_validation->run() === TRUE) {
					// Ambil ID order
					$lb_id = "";
					$data_order = $this->order_model->get_order_by_kode($kode);
					foreach ($data_order->result() as $dor) {
						$lb_id       = $dor->id;
						$curr_status = $dor->status;
					}

					// Gagalkan proses jika statusnya selesai.
					if ($curr_status>=6) {
						redirect('order/data_list', 'refresh');
					}

					// Order data array
					$data = array(
						'nama_konsumen' => $this->input->post('nama_konsumen'),
						'hp_konsumen'   => $this->input->post('hp_konsumen'),
						'alamat_lokasi' => $this->input->post('alamat_lokasi'),
						'motor'         => $this->input->post('motor'),
						'nomor_polisi'  => $this->input->post('nomor_polisi'),
						'jenis_velg'    => $this->input->post('jenis_velg'),
						'sumber_info'   => $this->input->post('sumber_info'),
						'cabang'        => $this->input->post('cabang'),
						'regional'      => $this->input->post('regional_id'),
						'toko'          => $this->input->post('toko'),
						'hapus'         => '0',
					);

					// Order detail data array
					$data_detail = array();
					$num         = 0;
					for ($i=0; $i < count($this->input->post('produk')); $i++) {
						// Hanya ambil array dengan data produk dan harga yang terisi data
						if (!empty($this->input->post('produk')[$i]) && !empty($this->input->post('harga')[$i])) {
							// Cek duplikat, jika data sudah ada set aktual = 1
							$detail_exists = $this->order_model->set_aktual_data_detail(
								$kode,
								$this->input->post('produk')[$i],
								$this->input->post('harga')[$i]
							);

							// Jika data tidak ada, insert data baru
							if ($detail_exists == FALSE) {
								$data_detail[$num] = array(
									'lb_kode'    => $kode,
									'keterangan' => 'Data baru setelah ubah data',
									'produk'     => $this->input->post('produk')[$i],
									'harga'      => $this->input->post('harga')[$i],
									'aktual'     => '0',
								);
								$num++;
							}

						}
					}

					// check to see if we are updating the data
					if ($this->order_model->update_data($data, $kode)) {
						// Hapus semua data yang tidak di aktualkan
						$data_hapus['hapus']      = '1';
						$data_hapus['keterangan'] = 'Data dihapus saat proses perubahan data';
						if ($this->order_model->update_data_detail($data_hapus, $kode, '0')) {
							// Update aktual = 0
							// Minor Bug : keterangan masih sesuai dengan aktual
							$data_fix['aktual'] = '0';
							$this->order_model->update_data_detail($data_fix, $kode);

							// Insert data yang baru (jika ada)
							$this->order_model->insert_data_detail($lb_id, $data_detail);

							// Insert log ubah
							$data_ubah = array(
								'lb_id'      => $lb_id,
								'lb_kode'    => $kode,
								'keterangan' => $this->input->post('keterangan_ubah'),
							);
							$this->order_model->insert_data_ubah($data_ubah);

							// Set message
							$this->session->set_flashdata('message',
								$this->config->item('message_start_delimiter', 'ion_auth')
								."Pesanan sudah berhasil diubah!".
								$this->config->item('message_end_delimiter', 'ion_auth')
							);
						}
						else {
							// Fail to save the detail
							$this->session->set_flashdata('message',
								$this->config->item('error_start_delimiter', 'ion_auth')
								."Detail Pesanan gagal diubah!".
								$this->config->item('error_end_delimiter', 'ion_auth')
							);
						}
					}
					else {
						// Set message
						$this->session->set_flashdata('message',
							$this->config->item('error_start_delimiter', 'ion_auth')
							."Data pesanan gagal diubah!".
							$this->config->item('error_end_delimiter', 'ion_auth')
						);
					}
					redirect('order/data_list', 'refresh');
				}

			}

			$this->data['kode']          = $kode;
			$this->data['data_header']   = $this->order_model->get_order_by_kode($kode);
			$this->data['data_detail']   = $this->order_model->get_order_detail_by_kode($kode);

			foreach ($this->data['data_header']->result() as $current_header) {
				$current_cabang   = $current_header->cabang;
				$current_regional = $current_header->regional;
				$current_toko     = $current_header->toko;
			}

			$this->data['cabang_list']      = $this->cabang_model->get_cabang("", "1");
			$this->data['current_cabang']   = $current_cabang;
			$this->data['regional_list']    = $this->regional_model->get_regional_by_cabang($current_cabang);
			$this->data['current_regional'] = $current_regional;
			$this->data['jenis_velg_list']  = $this->jenis_velg_model->get_jenis_velg();
			$this->data['toko_list']        = $this->toko_model->get_toko_by_regional($current_regional);
			$this->data['current_toko']     = $current_toko;

			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$this->load->view('partials/_alte_header', $this->data);
			$this->load->view('partials/_alte_menu');
			$this->load->view('order/edit');
			$this->load->view('partials/_alte_footer');
			$this->load->view('order/js');
		}
	}

	/**
	*	Detail layanan bantu
	*
	*	@param 		string
	*	@return 	void
	*
	*/
	public function detail($kode, $tanggal_awal="", $tanggal_akhir="")
	{
		// Jika tidak login, kembalikan ke halaman utama
		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login', 'refresh');
		}
		// Jika login
		else
		{
			// Jika toko, kembalikan ke order aktif
			if ($this->ion_auth->in_group('toko')) {
				redirect('order/my_order', 'refresh');
			}
			$this->data['kode']          = $kode;
			$this->data['data_header']   = $this->order_model->get_order_by_kode($kode);
			$this->data['data_detail']   = $this->order_model->get_order_detail_by_kode($kode);
			$this->data['tanggal_awal']  = $tanggal_awal;
			$this->data['tanggal_akhir'] = $tanggal_akhir;

			// set the flash data error message if there is one
			$this->data['message']       = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$this->load->view('partials/_alte_header', $this->data);
			$this->load->view('partials/_alte_menu');
			$this->load->view('order/detail');
			$this->load->view('partials/_alte_footer');
			$this->load->view('order/js');
		}
	}

	/**
	*	Detail layanan bantu selesai
	*	Tampilan toko
	*
	*	@param 		string
	*	@return 	void
	*
	*/
	public function completed_detail($kode)
	{
		// Jika tidak login, kembalikan ke halaman utama
		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login', 'refresh');
		}
		// Jika login
		else
		{
			// Variable
			$this->data['kode']        = $kode;
			$this->data['data_header'] = $this->order_model->get_order_by_kode($kode);
			$this->data['data_detail'] = $this->order_model->get_order_detail_aktual_by_kode($kode);

			// set the flash data error message if there is one
			$this->data['message']     = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			// Jika user adalah toko dan detail bukan untuk toko tersebut
			$toko = $this->data['username'];
			if ($this->ion_auth->in_group('toko')) {
				// Loop untuk mendapatkan detail mengenai toko yang di assign tugas
				$assigned_toko = "";
				foreach ($this->data['data_header']->result() as $data) {
					$assigned_toko = $data->toko;
				}
				if ($toko != $assigned_toko) {
					redirect('order/completed', 'refresh');
				}
			}

			$this->load->view('partials/_alte_header', $this->data);
			$this->load->view('partials/_alte_menu');
			$this->load->view('order/detail_completed');
			$this->load->view('partials/_alte_footer');
			$this->load->view('order/js');
		}
	}

}
