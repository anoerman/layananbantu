<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*	Regional model
*
*
*/
class Regional_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();

		$this->cabang_table   = 'master_cabang';
		$this->regional_table = 'master_regional';
		$this->user_table     = 'users';
		$this->loggedinuser   = $this->ion_auth->user()->row();
	}

	/**
	*	Get Regional
	*	from regional table
	*
	*	@param 		string 		$id
	*	@return 	array 		$datas
	*
	*/
	public function get_regional($id="", $aktif="")
	{
		if ($id!="") {
			$this->db->where('id', $id);
		}
		if ($aktif!="") {
			$this->db->where('aktif', $aktif);
		}
		$datas = $this->db->get($this->regional_table);
		return $datas;
	}


	/**
	*	Get Regional Limit
	*	from regional table
	*	sort by id desc
	*
	*	@param 		string 		$id
	*	@param 		string 		$limit
	*	@param 		string 		$start
	*	@param 		string 		$order_method
	*	@return 	array 		$datas
	*
	*/
	public function get_regional_pagination($id='',$limit='', $start='', $order_method='desc')
	{
		$this->db->select(
			$this->regional_table.".id, ".
			$this->regional_table.".nama, ".
			$this->regional_table.".cabang_id, ".
			$this->regional_table.".aktif, ".
			$this->cabang_table.".nama AS nama_cabang, ".
			$this->user_table.".username, ".
			$this->user_table.".first_name, ".
			$this->user_table.".last_name"
		);
		$this->db->from($this->regional_table);

		// join user table
		$this->db->join(
			$this->user_table,
			$this->regional_table.'.created_by = '.$this->user_table.'.username',
			'left');

		// join cabang table
		$this->db->join(
			$this->cabang_table,
			$this->regional_table.'.cabang_id = '.$this->cabang_table.'.id',
			'left');

		$this->db->where($this->regional_table.'.aktif', '1');

		// if ID provided
		if ($id!='') {
			$this->db->where($this->regional_table.'.id', $id);
		}

		// if limit and start provided
		if ($limit!="") {
			$this->db->limit($limit, $start);
		}

		// order by
		if ($order_method!="") {
			$this->db->order_by($this->regional_table.'.id', $order_method);
		}

		$datas = $this->db->get();
		return $datas;
	}

	/**
	*	Insert regional
	*	from regional form
	*
	*	@param 		array 		$datas
	*	@return 	bool
	*
	*/
	public function insert_regional($datas)
	{
		// user and datetime
		$datas['created_by'] = $this->loggedinuser->username;
		$datas['updated_by'] = $this->loggedinuser->username;
		$this->db->set('created_on', 'NOW()', FALSE);
		$this->db->set('updated_on', 'NOW()', FALSE);

		if ($this->db->insert($this->regional_table, $datas)) {
			return TRUE;
		}
		return FALSE;
	}

	/**
	*	Update Regional
	*	from regional edit form
	*	based on id
	*
	*	@param 		string 		$id
	*	@param 		array 		$datas
	*	@return 	void
	*
	*/
	public function update_regional($id, $datas)
	{
		// user and datetime
		$datas['updated_by'] = $this->loggedinuser->username;
		$this->db->set('updated_on', 'NOW()', FALSE);

		$this->db->where('id', $id);
		if($this->db->update($this->regional_table, $datas)) {
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
		$datas = $this->db->get($this->regional_table);

		return $datas;
	}

	/**
	*	Get regional by cabang
	*	from main table
	*
	*	@param 		string 		$cabang
	*	@return 	array 		$datas
	*
	*/
	public function get_regional_by_cabang($cabang)
	{
		$this->db->select(
			$this->regional_table.".*, ".
			$this->cabang_table.".nama AS nama_cabang "
		);
		$this->db->where($this->regional_table.'.cabang_id', $cabang);
		$this->db->join($this->cabang_table, $this->regional_table.".cabang_id = ".$this->cabang_table.".id", 'left');
		$datas = $this->db->get($this->regional_table);
		return $datas;
	}
	// End get_regional_by_cabang


}


// End of Regional model
