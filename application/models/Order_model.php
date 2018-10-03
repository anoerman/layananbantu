<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*	Order model
*
*
*/
class Order_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();

		$this->main_table         = 'layanan_bantu';
		$this->detail_table       = 'layanan_bantu_detail';
		$this->main_bayar_table   = 'layanan_bantu_bayar';
		$this->main_status_table  = 'layanan_bantu_status';
		$this->main_batal_table   = 'layanan_bantu_batal';
		$this->main_ubah_table    = 'layanan_bantu_ubah';
		$this->auto_produk_table  = 'master_auto_produk';
		$this->user_table         = 'users';
		$this->status_table       = 'master_status';
		$this->jenis_velg_table   = 'master_jenis_velg';
		$this->cabang_table       = 'master_cabang';
		$this->metode_pesan_table = 'master_metode_pesan';
		$this->regional_table     = 'master_regional';
		$this->loggedinuser       = $this->ion_auth->user()->row();
	}

	/**
	*	Code Check
	*	so that there's no duplicate code
	*
	*	@param 		string 		$kode
	*	@return 	bool
	*
	*/
	public function check_code($kode)
	{
		$this->db->where('kode', $kode);
		$datas = $this->db->get($this->main_table);
		if (count($datas->result())>0) {
			return FALSE;
		}
		else {
			return TRUE;
		}
	}
	// End of code check

	/**
	*	Get order
	*	from layanan_bantu table
	*
	*	@param 		string 		$id
	*	@return 	array 		$datas
	*
	*/
	public function get_order($id="")
	{
		if ($id!="") {
			$this->db->where('id', $id);
		}
		$this->db->where('hapus', 0);
		$datas = $this->db->get($this->main_table);
		return $datas;
	}
	// End of get_order

	/**
	*	Get order by status
	*	from layanan_bantu table
	*	sort by status
	*
	*	@param 		string 		$status
	*	@return 	array 		$datas
	*
	*/
	public function get_order_by_status($status="")
	{
		if ($status!="") {
			$this->db->where('status', $status);
		}
		$this->db->select(
			$this->main_table.".*, ".
			$this->user_table.".*, ".
			$this->status_table.".nama AS nama_status "
		);
		$this->db->join($this->user_table, $this->main_table.".toko = ".$this->user_table.".username", "left");
		$this->db->join($this->status_table, $this->main_table.".status = ".$this->status_table.".id", "left");
		$this->db->where('hapus', 0);
		$this->db->order_by($this->main_table.".id", "desc");
		$datas = $this->db->get($this->main_table);
		return $datas;
	}
	// End of get_order_by_status

	/**
	*	Get order cabang by status
	*	from layanan_bantu table
	*	sort by status
	*
	*	@param 		string 		$cabang
	*	@param 		string 		$status
	*	@return 	array 		$datas
	*
	*/
	public function get_order_cabang_by_status($cabang, $status="")
	{
		if ($status!="") {
			$this->db->where('status', $status);
		}
		if ($cabang!="0") {
			$this->db->where('cabang', $cabang);
		}
		$this->db->select(
			$this->main_table.".*, ".
			$this->user_table.".*, ".
			"user2.first_name AS cs_fn, ".
			"user2.last_name AS cs_ln, ".
			$this->status_table.".nama AS nama_status, ".
			$this->cabang_table.".nama AS nama_cabang, ".
			$this->regional_table.".nama AS nama_regional "
		);
		$this->db->join($this->user_table, $this->main_table.".toko = ".$this->user_table.".username", "left");
		$this->db->join($this->user_table ." AS user2", $this->main_table.".created_by = user2.username", "left");
		$this->db->join($this->status_table, $this->main_table.".status = ".$this->status_table.".id", "left");
		$this->db->join($this->cabang_table, $this->main_table.".cabang = ".$this->cabang_table.".id", "left");
		$this->db->join($this->regional_table, $this->main_table.".regional = ".$this->regional_table.".id", "left");
		$this->db->where('hapus', 0);
		$this->db->order_by($this->main_table.".id", "desc");
		$datas = $this->db->get($this->main_table);
		return $datas;
	}
	// End of get_order_cabang_by_status

	/**
	*	Get order history by date
	*	from layanan_bantu table
	*	get status = 6
	*	sort by date
	*
	*	@param 		string 		$tanggal_awal
	*	@param 		string 		$tanggal_akhir
	*	@param 		string 		$cabang
	*	@param 		string 		$regional
	*	@param 		string 		$status
	*	@return 	array 		$datas
	*
	*/
	public function get_order_history($tanggal_awal, $tanggal_akhir, $cabang, $regional, $status="")
	{
		// Format tanggal
		$awal  = date('Y-m-d', strtotime($tanggal_awal)) . " 00:00:00";
		$akhir = date('Y-m-d', strtotime($tanggal_akhir)) . " 23:59:59";

		// Filter cabang dan regional
		if ($cabang!="0" && $regional!="0") {
			$this->db->where('cabang', $cabang);
			$this->db->where_in('regional', $regional);
		}

		// Filter status
		if ($status!="") {
			$this->db->where('status', $status);
		}
		else {
			$this->db->where('status >=', '6');
		}

		$this->db->select(
			$this->main_table.".*, ".
			$this->user_table.".*, ".
			"user2.first_name AS cs_fn, ".
			"user2.last_name AS cs_ln, ".
			$this->status_table.".nama AS nama_status, ".
			$this->cabang_table.".nama AS nama_cabang, ".
			$this->regional_table.".nama AS nama_regional, ".
			$this->jenis_velg_table.".nama AS nama_jenis_velg "
		);
		$this->db->join($this->user_table, $this->main_table.".toko = ".$this->user_table.".username", "left");
		$this->db->join($this->user_table ." AS user2", $this->main_table.".created_by = user2.username", "left");
		$this->db->join($this->status_table, $this->main_table.".status = ".$this->status_table.".id", "left");
		$this->db->join($this->cabang_table, $this->main_table.".cabang = ".$this->cabang_table.".id", "left");
		$this->db->join($this->regional_table, $this->main_table.".regional = ".$this->regional_table.".id", "left");
		$this->db->join($this->jenis_velg_table, $this->main_table.".jenis_velg = ".$this->jenis_velg_table.".id", "left");
		$this->db->where('hapus', 0);
		$this->db->where('tanggal >=', $awal);
		$this->db->where('tanggal <=', $akhir);
		$this->db->order_by($this->main_table.".id", "desc");

		// // if limit and start provided
		// if ($limit!="") {
		// 	$this->db->limit($limit, $start);
		// }

		$datas = $this->db->get($this->main_table);
		return $datas;
	}
	// End of get_order_history

	/**
	*	Get order by kode
	*	from layanan_bantu table
	*	sort by kode
	*
	*	@param 		string 		$kode
	*	@return 	array 		$datas
	*
	*/
	public function get_order_by_kode($kode="")
	{
		if ($kode!="") {
			$this->db->where('kode', $kode);
		}
		$this->db->select(
			$this->main_table.".*, ".
			$this->user_table.".username, ".
			$this->user_table.".email, ".
			$this->user_table.".first_name, ".
			$this->user_table.".last_name, ".
			$this->user_table.".phone, ".
			$this->user_table.".cabang_id, ".
			"user2.first_name AS cs_fn, ".
			"user2.last_name AS cs_ln, ".
			$this->metode_pesan_table.".nama AS nama_metode_pesan, ".
			$this->status_table.".nama AS nama_status, ".
			$this->jenis_velg_table.".nama AS nama_jenis_velg, ".
			$this->cabang_table.".nama AS nama_cabang, ".
			$this->regional_table.".nama AS nama_regional, ".
			$this->main_bayar_table.".metode_bayar, ".
			$this->main_bayar_table.".go_pay_bayar, ".
			$this->main_bayar_table.".total_bayar "
		);
		$this->db->where('hapus', 0);
		$this->db->join($this->user_table, $this->main_table.".toko = ".$this->user_table.".username", "left");
		$this->db->join($this->user_table ." AS user2", $this->main_table.".created_by = user2.username", "left");
		$this->db->join($this->status_table, $this->main_table.".status = ".$this->status_table.".id", "left");
		$this->db->join($this->metode_pesan_table, $this->main_table.".metode_pesan = ".$this->metode_pesan_table.".id", "left");
		$this->db->join($this->jenis_velg_table, $this->main_table.".jenis_velg = ".$this->jenis_velg_table.".id", "left");
		$this->db->join($this->cabang_table, $this->main_table.".cabang = ".$this->cabang_table.".id", "left");
		$this->db->join($this->regional_table, $this->main_table.".regional = ".$this->regional_table.".id", "left");
		$this->db->join($this->main_bayar_table, $this->main_table.".id = ".$this->main_bayar_table.".lb_id", "left");
		$this->db->order_by($this->main_table.".id", "desc");
		$datas = $this->db->get($this->main_table);
		return $datas;
	}
	// End of get_order_by_kode

	/**
	*	Get order toko by status
	*	from layanan_bantu table
	*	based on current toko
	*	sort by status
	*
	*	@param 		string 		$toko
	*	@param 		string 		$status
	*	@return 	array 		$datas
	*
	*/
	public function get_order_toko_by_status($toko, $status="")
	{
		if ($status!="") {
			$this->db->where('status', $status);
		}
		$this->db->where('toko', $toko);
		$this->db->where('hapus', 0);
		$this->db->select(
			$this->main_table.".*, ".
			$this->user_table.".*, ".
			$this->status_table.".nama AS nama_status "
		);
		$this->db->join($this->user_table, $this->main_table.".toko = ".$this->user_table.".username", "left");
		$this->db->join($this->status_table, $this->main_table.".status = ".$this->status_table.".id", "left");
		$this->db->order_by($this->main_table.".id", "desc");
		$datas = $this->db->get($this->main_table);
		return $datas;
	}
	// End of get_order_toko_by_status

	/**
	*	Get order toko aktif
	*	from layanan_bantu table
	*	based on current toko
	*
	*	@param 		string		$toko
	*	@return 	array 		$datas
	*
	*/
	public function get_order_toko_aktif($toko)
	{
		$this->db->select(
			$this->main_table.".*, ".
			$this->user_table.".*, ".
			$this->status_table.".nama AS nama_status "
		);
		$this->db->where('status <', 6);
		$this->db->where('hapus', 0);
		$this->db->where('toko', $toko);
		$this->db->join($this->user_table, $this->main_table.".toko = ".$this->user_table.".username", "left");
		$this->db->join($this->status_table, $this->main_table.".status = ".$this->status_table.".id", "left");
		$this->db->order_by($this->main_table.".id", "desc");
		$datas = $this->db->get($this->main_table);
		return $datas;
	}
	// End of get_order_toko_aktif

	/**
	*	Get order toko selesai
	*	from layanan_bantu table
	*	based on current toko
	*
	*	@param 		string		$toko
	*	@return 	array 		$datas
	*
	*/
	public function get_order_toko_selesai($toko, $limit='', $start='')
	{
		$this->db->select(
			$this->main_table.".*, ".
			$this->user_table.".*, ".
			"user2.first_name AS cs_fn, ".
			"user2.last_name AS cs_ln, ".
			$this->metode_pesan_table.".nama AS nama_metode_pesan, ".
			$this->status_table.".nama AS nama_status, ".
			$this->cabang_table.".nama AS nama_cabang, ".
			$this->regional_table.".nama AS nama_regional, ".
			$this->main_bayar_table.".metode_bayar, ".
			$this->main_bayar_table.".go_pay_bayar, ".
			$this->main_bayar_table.".total_bayar "
		);
		$this->db->where('status', 6);
		$this->db->where('hapus', 0);
		$this->db->where('toko', $toko);
		$this->db->join($this->user_table, $this->main_table.".toko = ".$this->user_table.".username", "left");
		$this->db->join($this->user_table ." AS user2", $this->main_table.".created_by = user2.username", "left");
		$this->db->join($this->status_table, $this->main_table.".status = ".$this->status_table.".id", "left");
		$this->db->join($this->metode_pesan_table, $this->main_table.".metode_pesan = ".$this->metode_pesan_table.".id", "left");
		$this->db->join($this->cabang_table, $this->main_table.".cabang = ".$this->cabang_table.".id", "left");
		$this->db->join($this->regional_table, $this->main_table.".regional = ".$this->regional_table.".id", "left");
		$this->db->join($this->main_bayar_table, $this->main_table.".id = ".$this->main_bayar_table.".lb_id", "left");
		$this->db->order_by($this->main_table.".id", "desc");

		// if limit and start provided
		if ($limit!="") {
			$this->db->limit($limit, $start);
		}

		$datas = $this->db->get($this->main_table);
		return $datas;
	}
	// End of get_order_toko_selesai

	/**
	*	Get order detail by kode
	*	from layanan_bantu_detail table
	*	sort by kode
	*
	*	@param 		string 		$kode
	*	@return 	array 		$datas
	*
	*/
	public function get_order_detail_by_kode($kode="")
	{
		if ($kode!="") {
			$this->db->where('lb_kode', $kode);
		}
		$this->db->where('hapus', 0);
		$datas = $this->db->get($this->detail_table);
		return $datas;
	}
	// End of get_order_detail_by_kode

	/**
	*	Get order detail aktual by kode
	*	from layanan_bantu_detail table
	*	sort by kode
	*
	*	@param 		string 		$kode
	*	@return 	array 		$datas
	*
	*/
	public function get_order_detail_aktual_by_kode($kode="")
	{
		if ($kode!="") {
			$this->db->where('lb_kode', $kode);
		}
		$this->db->where('aktual', 1);
		$this->db->where('hapus', 0);
		$datas = $this->db->get($this->detail_table);
		return $datas;
	}
	// End of get_order_detail_aktual_by_kode

	/**
	*	Get order status by kode
	*	from layanan_bantu_status table
	*	sort by kode
	*
	*	@param 		string 		$kode
	*	@return 	array 		$datas
	*
	*/
	public function get_order_status_by_kode($kode)
	{
		$this->db->where('lb_kode', $kode);
		$datas = $this->db->get($this->main_status_table);
		return $datas;
	}
	// End of get_order_status_by_kode

	/**
	*	Get order ubah by kode
	*	from layanan_bantu_ubah table
	*	sort by kode
	*
	*	@param 		string 		$kode
	*	@return 	array 		$datas
	*
	*/
	public function get_order_ubah_by_kode($kode)
	{
		$this->db->where('lb_kode', $kode);
		$datas = $this->db->get($this->main_ubah_table);
		return $datas;
	}
	// End of get_order_ubah_by_kode

	/**
	*	Get order batal by kode
	*	from layanan_bantu_batal table
	*	sort by kode
	*
	*	@param 		string 		$kode
	*	@return 	array 		$datas
	*
	*/
	public function get_order_batal_by_kode($kode)
	{
		$this->db->where('lb_kode', $kode);
		$datas = $this->db->get($this->main_batal_table);
		return $datas;
	}
	// End of get_order_batal_by_kode


	/**
	*	Insert Data
	*	From controller
	*
	*	@param 		array
	*	@return 	bool
	*
	*/
	public function insert_data($datas)
	{
		// user and datetime
		$datas['created_by'] = $this->loggedinuser->username;
		$datas['updated_by'] = $this->loggedinuser->username;
		$this->db->set('created_on', 'NOW()', FALSE);
		$this->db->set('updated_on', 'NOW()', FALSE);

		// Insert to main table
		if ($this->db->insert($this->main_table, $datas)) {
			return TRUE;
		}
		return FALSE;
	}
	// End of insert_data

	/**
	*	Insert Detail Data
	*	From controller
	*
	*	@param 		string
	*	@param 		array
	*	@return 	bool
	*
	*/
	public function insert_data_detail($lb_id, $datas)
	{
		$total_data = count($datas);
		if ($total_data>0) {
			$num = 0;
			for ($i=0; $i < $total_data; $i++) {
				// user and datetime & additional data
				$data['lb_kode']    = $datas[$num]['lb_kode'];
				$data['produk']     = $datas[$num]['produk'];
				$data['harga']      = $datas[$num]['harga'];
				$data['keterangan'] = $datas[$num]['keterangan'];
				$data['aktual']     = $datas[$num]['aktual'];
				$data['lb_id']      = $lb_id;
				$data['created_by'] = $this->loggedinuser->username;
				$data['updated_by'] = $this->loggedinuser->username;
				$this->db->set('created_on', 'NOW()', FALSE);
				$this->db->set('updated_on', 'NOW()', FALSE);

				// Insert to detail table
				if ($this->db->insert($this->detail_table, $data)) {
					$num++;
				}

				// Cek produk & insert it into master_auto_produk if it doesn't exists
				$this->insert_data_auto_produk($data['produk']);

			}
			// If total is the same as inserted datas
			if ($num == $total_data) {
				return TRUE;
			}
			return FALSE;
		}
		else {
			return FALSE;
		}
	}
	// End of insert_data_detail

	/**
	*	Insert Bayar Data
	*	From controller
	*
	*	@param 		string
	*	@param 		array
	*	@return 	bool
	*
	*/
	public function insert_data_bayar($lb_id, $datas)
	{
		$datas['lb_id']      = $lb_id;
		// user and datetime
		$datas['created_by'] = $this->loggedinuser->username;
		$this->db->set('created_on', 'NOW()', FALSE);
		$datas['updated_by'] = $this->loggedinuser->username;
		$this->db->set('updated_on', 'NOW()', FALSE);

		// Insert to table
		if ($this->db->insert($this->main_bayar_table, $datas)) {
			return TRUE;
		}
		return FALSE;
	}
	// End of insert_data_bayar

	/**
	*	Insert Status Data
	*	From controller
	*
	*	@param 		string
	*	@param 		array
	*	@return 	bool
	*
	*/
	public function insert_data_status($lb_id, $datas)
	{
		$datas['lb_id']      = $lb_id;
		// user and datetime
		$datas['created_by'] = $this->loggedinuser->username;
		$this->db->set('created_on', 'NOW()', FALSE);

		// Insert to main table
		if ($this->db->insert($this->main_status_table, $datas)) {
			return TRUE;
		}
		return FALSE;
	}
	// End of insert_data_status

	/**
	*	Insert Batal Data
	*	From controller
	*
	*	@param 		array
	*	@return 	bool
	*
	*/
	public function insert_data_batal($datas)
	{
		// user and datetime
		$datas['created_by'] = $this->loggedinuser->username;
		$this->db->set('created_on', 'NOW()', FALSE);

		// Insert to main table
		if ($this->db->insert($this->main_batal_table, $datas)) {
			return TRUE;
		}
		return FALSE;
	}
	// End of insert_data_batal

	/**
	*	Insert Ubah Data
	*	From controller
	*
	*	@param 		array
	*	@return 	bool
	*
	*/
	public function insert_data_ubah($datas)
	{
		// user and datetime
		$datas['created_by'] = $this->loggedinuser->username;
		$this->db->set('created_on', 'NOW()', FALSE);

		// Insert to main table
		if ($this->db->insert($this->main_ubah_table, $datas)) {
			return TRUE;
		}
		return FALSE;
	}
	// End of insert_data_ubah

	/**
	*	Insert to master_auto_produk
	*	Jika data sudah ada di master, maka tambahkan total
	*	Jika data tidak ada di master, maka tambahkan datanya
	*
	*	@param 		string
	*	@return 	bool
	*
	*/
	public function insert_data_auto_produk($produk)
	{
		// Check first
		$this->db->where('produk', $produk);
		$check = $this->db->get($this->auto_produk_table);
		// Add total if data exists
		if (count($check->result())>0) {
			foreach ($check->result() as $result) {
				$id    = $result->id;
				$total = $result->total + 1;
			}
			// Add total data to auto produk
			$data['total'] = $total;
			$this->db->where('id', $id);
			if ($this->db->update($this->auto_produk_table, $data)){
				return TRUE;
			}
			return FALSE;
		}
		// Add new auto produk
		else {
			$data['produk'] = $produk;
			$data['total']  = 1;
			$this->db->set('created_on', 'NOW()', FALSE);
			if ($this->db->insert($this->auto_produk_table, $data)) {
				return TRUE;
			}
			return FALSE;
		}
		return FALSE;
	}
	// End insert_data_auto_produk


	/**
	*	Update Data
	*	From controller
	*
	*	@param 		array
	*	@param 		string
	*	@return 	bool
	*
	*/
	public function update_data($datas, $kode)
	{
		// user and datetime
		$datas['updated_by'] = $this->loggedinuser->username;
		$this->db->set('updated_on', 'NOW()', FALSE);

		// Update to main table
		$this->db->where('kode', $kode);
		if ($this->db->update($this->main_table, $datas)) {
			return TRUE;
		}
		return FALSE;
	}
	// End of update_data

	/**
	*	Update Data Detail
	*	From controller
	*
	*	@param 		array
	*	@param 		string
	*	@return 	bool
	*
	*/
	public function update_data_detail($datas, $kode, $actual="")
	{
		// user and datetime
		$datas['updated_by'] = $this->loggedinuser->username;
		$this->db->set('updated_on', 'NOW()', FALSE);

		// Set actual where
		if ($actual!="") {
			$this->db->where('aktual', $actual);
		}

		// Update to main table
		$this->db->where('lb_kode', $kode);
		if ($this->db->update($this->detail_table, $datas)) {
			return TRUE;
		}
		return FALSE;
	}
	// End of update_data_detail

	/**
	*	Update Order Status
	*	From controller
	*
	*	@param 		string
	*	@param 		array
	*	@return 	bool
	*
	*/
	public function update_order_status($kode, $datas)
	{
		// Set new var
		$lb_id       = $datas['lb_id'];
		$data_status = $datas;

		// user and datetime
		unset($datas['lb_id'], $datas['lb_kode']);
		$datas['updated_by'] = $this->loggedinuser->username;
		$this->db->set('updated_on', 'NOW()', FALSE);

		// Update main table
		$this->db->where($this->main_table.".kode", $kode);
		if ($this->db->update($this->main_table, $datas)) {
			// Insert status table
			if ($this->insert_data_status($lb_id, $data_status)) {
				return TRUE;
			}
			return FALSE;
		}
		return FALSE;
	}
	// End of update_order_status

	/**
	*	Update Data Bayar
	*	From controller
	*
	*	@param 		array
	*	@param 		string
	*	@return 	bool
	*
	*/
	public function update_data_bayar($datas, $lb_id)
	{
		// user and datetime
		$datas['updated_by'] = $this->loggedinuser->username;
		$this->db->set('updated_on', 'NOW()', FALSE);

		// Update to main table
		$this->db->where('lb_id', $lb_id);
		if ($this->db->update($this->main_bayar_table, $datas)) {
			return TRUE;
		}
		return FALSE;
	}
	// End of update_data_bayar


	/**
	*	Actual-ing data detail
	*	Check if data detail exists in the detail table
	*	If data exists, update it to actual
	*
	*	@param 		string
	*	@param 		string
	*	@param 		string
	*	@return 	bool
	*
	*/
	public function set_aktual_data_detail($kode, $produk, $harga)
	{
		$this->db->where('lb_kode', $kode);
		$this->db->where('produk', $produk);
		$this->db->where('harga', $harga);
		$datas = $this->db->get($this->detail_table);
		if (count($datas->result()) > 0) {
			// Update aktual
			$this->db->set('updated_on', 'NOW()', FALSE);
			$this->db->set('updated_by', $this->loggedinuser->username);
			$this->db->set('aktual', '1');
			$this->db->set('keterangan', 'produk sesuai dengan pesanan');
			$this->db->where('lb_kode', $kode);
			$this->db->where('produk', $produk);
			$this->db->where('harga', $harga);
			if ($this->db->update($this->detail_table)) {
				return TRUE;
			}
			else {
				return FALSE;
			}
		}
		return FALSE;
	}

}


// End of Order model
