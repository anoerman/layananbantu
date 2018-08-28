<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*	Toko model
*
*
*/
class Toko_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();

		$this->main_table     = 'users';
		$this->group_table    = 'users_groups';
		$this->order_table    = 'layanan_bantu';
		$this->regional_table = 'master_regional';
	}

	/**
	*	Get Toko
	*	from main table
	*
	*	@param 		string 		$cabang
	*	@param 		string 		$username
	*	@return 	array 		$datas
	*
	*/
	public function get_toko($cabang, $username="")
	{
		if ($username!="") {
			$this->db->where('username', $username);
		}
		$this->db->join($this->group_table, $this->main_table.".id = ".$this->group_table.".user_id", 'left');
		$this->db->where('cabang_id', $cabang);
		$this->db->where('group_id', '3');
		$datas = $this->db->get($this->main_table);
		return $datas;
	}
	// End get_toko

	/**
	*	Get Toko Aktif
	*	Hanya ambil data toko yang tidak memiliki order aktif
	* atau sudah selesai ordernya.
	*
	*	@param 		string 		$cabang
	*	@param 		string 		$username
	*	@return 	array 		$datas
	*
	*/
	public function get_toko_aktif($cabang, $username="")
	{
		if ($username!="") {
			$this->db->where('username', $username);
		}
		$this->db->join($this->group_table, $this->main_table.".id = ".$this->group_table.".user_id", 'left');
		$this->db->join($this->order_table, $this->main_table.".username = ".$this->order_table.".toko AND ".$this->order_table.".status != '6'", 'left');
		$this->db->where($this->main_table.'.cabang_id', $cabang);
		$this->db->where($this->group_table.'.group_id', '3');
		$where = "( ".$this->order_table.".status='6' OR ".$this->order_table.".status IS NULL )";
		$this->db->where($where);
		$datas = $this->db->get($this->main_table);
		return $datas;
	}
	// End of get_toko_aktif

	/**
	*	Get Toko By Cabang
	*	from main table
	*
	*	@param 		string 		$cabang
	*	@return 	array 		$datas
	*
	*/
	public function get_toko_by_cabang($cabang)
	{
		$this->db->join($this->group_table, $this->main_table.".id = ".$this->group_table.".user_id", 'left');
		$this->db->join(
			$this->order_table,
			$this->main_table.".username = ".$this->order_table.".toko AND ".$this->order_table.".status < '6'", 'left');
		$this->db->where($this->main_table.'.cabang_id', $cabang);
		$this->db->where($this->group_table.'.group_id', '3');
		$where = "( ".$this->order_table.".status='6' OR ".$this->order_table.".status IS NULL )";
		$this->db->where($where);
		$datas = $this->db->get($this->main_table);
		return $datas;
	}
	// End get_toko_by_cabang

	/**
	*	Get Toko By regional
	*	from main table
	*
	*	@param 		string 		$regional
	*	@return 	array 		$datas
	*
	*/
	public function get_toko_by_regional($regional)
	{
		$this->db->join($this->group_table, $this->main_table.".id = ".$this->group_table.".user_id", 'left');
		$this->db->join(
			$this->order_table,
			$this->main_table.".username = ".$this->order_table.".toko AND ".$this->order_table.".status < '6'", 'left');
		$this->db->where($this->main_table.'.regional_id', $regional);
		$this->db->where($this->group_table.'.group_id', '3');
		$where = "( ".$this->order_table.".status='6' OR ".$this->order_table.".status IS NULL )";
		$this->db->where($where);
		$datas = $this->db->get($this->main_table);
		return $datas;
	}
	// End get_toko_by_regional


}


// End of Toko model
