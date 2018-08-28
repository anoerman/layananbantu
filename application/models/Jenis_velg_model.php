<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*	Jenis_velg model
*
*
*/
class Jenis_velg_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();

		$this->main_table = 'master_jenis_velg';
		$this->user_table = 'users';
	}

	/**
	*	Get Jenis_velg
	*	from jenis_velg table
	*
	*	@param 		string 		$id
	*	@return 	array 		$datas
	*
	*/
	public function get_jenis_velg($id="")
	{
		if ($id!="") {
			$this->db->where('id', $id);
		}
		$datas = $this->db->get($this->main_table);
		return $datas;
	}


}


// End of Jenis_velg model
