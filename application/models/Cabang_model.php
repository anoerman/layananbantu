<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*	Cabang model
*
*
*/
class Cabang_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();

		$this->cabang_table = 'master_cabang';
		$this->user_table   = 'users';
		$this->loggedinuser = $this->ion_auth->user()->row();
	}

	/**
	*	Get Cabang
	*	from cabang table
	*
	*	@param 		string 		$id
	*	@return 	array 		$datas
	*
	*/
	public function get_cabang($id="", $aktif="")
	{
		if ($id!="") {
			$this->db->where('id', $id);
		}
		if ($aktif!="") {
			$this->db->where('aktif', $aktif);
		}
		$datas = $this->db->get($this->cabang_table);
		return $datas;
	}


	/**
	*	Get Cabang Limit
	*	from cabang table
	*	sort by id desc
	*
	*	@param 		string 		$id
	*	@param 		string 		$limit
	*	@param 		string 		$start
	*	@param 		string 		$order_method
	*	@return 	array 		$datas
	*
	*/
	public function get_cabang_pagination($id='',$limit='', $start='', $order_method='desc')
	{
		$this->db->select(
			$this->cabang_table.".id, ".
			$this->cabang_table.".slug, ".
			$this->cabang_table.".nama, ".
			$this->cabang_table.".aktif, ".
			$this->user_table.".username, ".
			$this->user_table.".first_name, ".
			$this->user_table.".last_name"
		);
		$this->db->from($this->cabang_table);

		// join user table
		$this->db->join(
			$this->user_table,
			$this->cabang_table.'.created_by = '.$this->user_table.'.username',
			'left');

		$this->db->where($this->cabang_table.'.aktif', '1');

		// if ID provided
		if ($id!='') {
			$this->db->where($this->cabang_table.'.id', $id);
		}

		// if limit and start provided
		if ($limit!="") {
			$this->db->limit($limit, $start);
		}

		// order by
		if ($order_method!="") {
			$this->db->order_by($this->cabang_table.'.id', $order_method);
		}

		$datas = $this->db->get();
		return $datas;
	}

	/**
	*	Insert cabang
	*	from cabang form
	*
	*	@param 		array 		$datas
	*	@return 	bool
	*
	*/
	public function insert_cabang($datas)
	{
		// user and datetime
		$datas['created_by'] = $this->loggedinuser->username;
		$datas['updated_by'] = $this->loggedinuser->username;
		$this->db->set('created_on', 'NOW()', FALSE);
		$this->db->set('updated_on', 'NOW()', FALSE);

		if ($this->db->insert($this->cabang_table, $datas)) {
			return TRUE;
		}
		return FALSE;
	}

	/**
	*	Update Cabang
	*	from cabang edit form
	*	based on id
	*
	*	@param 		string 		$id
	*	@param 		array 		$datas
	*	@return 	void
	*
	*/
	public function update_cabang($id, $datas)
	{
		// user and datetime
		$datas['updated_by'] = $this->loggedinuser->username;
		$this->db->set('updated_on', 'NOW()', FALSE);

		$this->db->where('id', $id);
		if($this->db->update($this->cabang_table, $datas)) {
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
		$datas = $this->db->get($this->cabang_table);

		return $datas;
	}



}


// End of Cabang model
