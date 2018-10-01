<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*	Metode Pesan model
*
*
*/
class Metode_pesan_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();

		$this->metode_pesan_table = 'master_metode_pesan';
		$this->user_table         = 'users';
		$this->loggedinuser       = $this->ion_auth->user()->row();
	}

	/**
	*	Get Metode Pesan
	*	from metode_pesan table
	*
	*	@param 		string 		$id
	*	@return 	array 		$datas
	*
	*/
	public function get_metode_pesan($id="", $aktif="")
	{
		if ($id!="") {
			$this->db->where('id', $id);
		}
		if ($aktif!="") {
			$this->db->where('aktif', $aktif);
		}
		$datas = $this->db->get($this->metode_pesan_table);
		return $datas;
	}


	/**
	*	Get Metode Pesan Limit
	*	from metode_pesan table
	*	sort by id desc
	*
	*	@param 		string 		$id
	*	@param 		string 		$limit
	*	@param 		string 		$start
	*	@param 		string 		$order_method
	*	@return 	array 		$datas
	*
	*/
	public function get_metode_pesan_pagination($id='',$limit='', $start='', $order_method='desc')
	{
		$this->db->select(
			$this->metode_pesan_table.".id, ".
			$this->metode_pesan_table.".nama, ".
			$this->metode_pesan_table.".aktif, ".
			$this->user_table.".username, ".
			$this->user_table.".first_name, ".
			$this->user_table.".last_name"
		);
		$this->db->from($this->metode_pesan_table);

		// join user table
		$this->db->join(
			$this->user_table,
			$this->metode_pesan_table.'.created_by = '.$this->user_table.'.username',
			'left');

		$this->db->where($this->metode_pesan_table.'.aktif', '1');

		// if ID provided
		if ($id!='') {
			$this->db->where($this->metode_pesan_table.'.id', $id);
		}

		// if limit and start provided
		if ($limit!="") {
			$this->db->limit($limit, $start);
		}

		// order by
		if ($order_method!="") {
			$this->db->order_by($this->metode_pesan_table.'.id', $order_method);
		}

		$datas = $this->db->get();
		return $datas;
	}

	/**
	*	Insert metode_pesan
	*	from metode_pesan form
	*
	*	@param 		array 		$datas
	*	@return 	bool
	*
	*/
	public function insert_metode_pesan($datas)
	{
		// user and datetime
		$datas['created_by'] = $this->loggedinuser->username;
		$datas['updated_by'] = $this->loggedinuser->username;
		$this->db->set('created_on', 'NOW()', FALSE);
		$this->db->set('updated_on', 'NOW()', FALSE);

		if ($this->db->insert($this->metode_pesan_table, $datas)) {
			return TRUE;
		}
		return FALSE;
	}

	/**
	*	Update Metode Pesan
	*	from metode_pesan edit form
	*	based on id
	*
	*	@param 		string 		$id
	*	@param 		array 		$datas
	*	@return 	void
	*
	*/
	public function update_metode_pesan($id, $datas)
	{
		// user and datetime
		$datas['updated_by'] = $this->loggedinuser->username;
		$this->db->set('updated_on', 'NOW()', FALSE);

		$this->db->where('id', $id);
		if($this->db->update($this->metode_pesan_table, $datas)) {
			return TRUE;
		}
		return FALSE;
	}


	/**
	* Name check
	* If duplicate FALSE
	* Else TRUE
	*
	* @param 		string		$name
	* @return 	array
	*
	*/
	public function name_check($name)
	{
		$this->db->where('nama', trim($name));
		$datas = $this->db->get($this->metode_pesan_table);

		return $datas;
	}



}


// End of Metode Pesan model
