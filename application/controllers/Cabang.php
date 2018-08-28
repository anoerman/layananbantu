<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*	Cabang Controller
*
*	@author Noerman Agustiyan
* 				noerman.agustiyan@gmail.com
*					@anoerman
*
*	@link 	https://github.com/anoerman
*		 			https://gitlab.com/anoerman
*
*	Accessible for admin user group
*
*/
class Cabang extends CI_Controller {

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
				'cabang_model',
			)
		);

		// default datas
		// used in every pages
		if ($this->ion_auth->logged_in()) {
			// user detail
			$loggedinuser = $this->ion_auth->user()->row();
      $this->data['username']       = $loggedinuser->username;
			$this->data['user_full_name'] = $loggedinuser->first_name . " " . $loggedinuser->last_name;
			$this->data['user_photo']     = $this->profile_model->get_user_photo($loggedinuser->username)->row();
      $this->data['user_cabang']    = $loggedinuser->cabang_id;
		}
	}

	/**
	*	Index Page for this controller.
	*	Showing list of cabang and add new form
	*
	*	@param 		string 		$page
	*	@return 	void
	*
	*/
	public function index($page="")
	{
		// Not logged in, redirect to home
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login/cabang', 'refresh');
		}
		// Logged in
		else{
			$this->data['data_list'] = $this->cabang_model->get_cabang_pagination();

			// Set pagination
			$config['base_url']         = base_url('cabang/index');
			$config['use_page_numbers'] = TRUE;
			$config['total_rows']       = count($this->data['data_list']->result());
			$config['per_page']         = 15;
			$this->pagination->initialize($config);

			// Get datas and limit based on pagination settings
			if ($page=="") { $page = 1; }
			$this->data['data_list'] = $this->cabang_model->get_cabang_pagination("",
				$config['per_page'],
				( $page - 1 ) * $config['per_page']
			);
			// $this->data['last_query'] = $this->db->last_query();
			$this->data['pagination'] = $this->pagination->create_links();

			// set the flash data error message if there is one
			$this->data['message']   = (validation_errors()) ? validation_errors() :
			$this->session->flashdata('message');

			$this->load->view('partials/_alte_header', $this->data);
			$this->load->view('partials/_alte_menu');
			$this->load->view('cabang/index');
			$this->load->view('partials/_alte_footer');
			$this->load->view('cabang/js');
			$this->load->view('js_script');
		}
	}
	// Index end

	/**
	*	Add New Data
	*	If there's data sent, insert
	*	Else, show the form
	*
	*	@return 	void
	*
	*/
	public function add()
	{
		// Not logged in, redirect to home
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login/cabang', 'refresh');
		}
		// Logged in
		else {
			// input validation rules
			$this->form_validation->set_rules('nama', 'Nama Cabang', 'trim|addslashes|strip_tags|required|callback__name_check');

			// check if there's valid input
			if (isset($_POST) && !empty($_POST)) {
				// validation run
				if ($this->form_validation->run() === TRUE) {
					$data = array(
						'nama'  => $this->input->post('nama'),
						'slug'  => str_replace(" ", "-", strtolower($this->input->post('nama'))),
						'aktif' => '1',
					);

					// check to see if we are inserting the data
					if ($this->cabang_model->insert_cabang($data)) {
						$this->session->set_flashdata('message',
							$this->config->item('success_start_delimiter', 'ion_auth')
							."Data cabang berhasil disimpan".
							$this->config->item('success_end_delimiter', 'ion_auth')
						);
					}
					else {
						$this->session->set_flashdata('message',
							$this->config->item('error_start_delimiter', 'ion_auth')
							."Data cabang gagal disimpan".
							$this->config->item('error_end_delimiter', 'ion_auth')
						);
					}
					redirect('cabang', 'refresh');
				}

        // $this->session->set_flashdata('message',
        //   $this->config->item('error_start_delimiter', 'ion_auth')
        //   ."Data cabang dikirim namun gagal disimpan".
        //   $this->config->item('error_end_delimiter', 'ion_auth')
        // );
        // redirect('cabang', 'refresh');
      }

			$this->data['data_list'] = $this->cabang_model->get_cabang_pagination();
			$this->data['open_form'] = "open";

			// Set pagination
			$config['base_url']         = base_url('cabang/index');
			$config['use_page_numbers'] = TRUE;
			$config['total_rows']       = count($this->data['data_list']->result());
			$config['per_page']         = 15;
			$this->pagination->initialize($config);

			// Get datas and limit based on pagination settings
			$page = 1;
			$this->data['data_list'] = $this->cabang_model->get_cabang_pagination("",
				$config['per_page'],
				( $page - 1 ) * $config['per_page']
			);
			// $this->data['last_query'] = $this->db->last_query();
			$this->data['pagination'] = $this->pagination->create_links();

			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() :
			$this->session->flashdata('message');

			$this->load->view('partials/_alte_header', $this->data);
			$this->load->view('partials/_alte_menu');
			$this->load->view('cabang/index');
			$this->load->view('partials/_alte_footer');
			$this->load->view('cabang/js');
			$this->load->view('js_script');
		}
	}
	// Add data end

	/**
	*	Callback to check duplicate name
	*
	*	@param 		string 		$name
	*	@return 	bool
	*
	*/
	public function _name_check($name)
	{
		$datas = $this->cabang_model->name_check($name);
		$total = count($datas->result());
		if ($total == 0) {
			return TRUE;
		}
		else {
			$this->form_validation->set_message(
				'_name_check', '{field} dengan nama "'.$name.'" sudah ada di database.'
			);
			return FALSE;
		}
	}
	// End _name_check

	/**
	*	Edit Data
	*	If there's data sent, update
	*	Else, show the form
	*
	*	@param 		string 		$id
	*	@return 	void
	*
	*/
	public function edit($id)
	{
		// Not logged in, redirect to home
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login/cabang', 'refresh');
		}
		// Logged in
		else {
			// input validation rules
			$this->form_validation->set_rules('nama', 'Nama Cabang', 'trim|strip_tags|addslashes|required');

			// check if there's valid input
			if (isset($_POST) && !empty($_POST)) {
				// validation run
				if ($this->form_validation->run() === TRUE) {
					$data = array(
            'nama'  => $this->input->post('nama'),
						'slug'  => str_replace(" ", "-", strtolower($this->input->post('nama'))),
					);

					// check to see if we are updating the data
					if ($this->cabang_model->update_cabang($id, $data)) {
						$this->session->set_flashdata('message',
							$this->config->item('success_start_delimiter', 'ion_auth')
							."Cabang berhasil diubah!".
							$this->config->item('success_end_delimiter', 'ion_auth')
						);
					}
					else {
						$this->session->set_flashdata('message',
							$this->config->item('error_start_delimiter', 'ion_auth')
							."Cabang gagal diubah!".
							$this->config->item('error_end_delimiter', 'ion_auth')
						);
					}
					redirect('cabang', 'refresh');
				}
			}
			// Get data
			$this->data['data_list'] = $this->cabang_model->get_cabang_pagination($id);
			$this->data['id']        = $id;

			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() :
			$this->session->flashdata('message');

			$this->load->view('partials/_alte_header', $this->data);
			$this->load->view('partials/_alte_menu');
			$this->load->view('cabang/edit');
			$this->load->view('partials/_alte_footer');
			$this->load->view('cabang/js');
			$this->load->view('js_script');
		}
	}
	// Edit data end

	/**
	*	Delete Data
	*	If there's data sent, update deleted
	*	Else, redirect to cabang
	*
	*	@param 		string 		$id
	*	@return 	void
	*
	*/
	public function delete($id)
	{
		// Jika tidak login, kembalikan ke halaman utama
		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login/cabang', 'refresh');
		}
		// Jika login
		else
		{
			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() :
			$this->session->flashdata('message');

			// check if there's valid input
			if (isset($_POST) && !empty($_POST)) {

				// input validation rules
				$this->form_validation->set_rules('id', 'ID', 'trim|numeric|required');

				// validation run
				if ($this->form_validation->run() === TRUE) {
					$data = array(
						'aktif' => '0',
					);

					// check to see if we are updating the data
					if ($this->cabang_model->update_cabang($id, $data)) {
						$this->session->set_flashdata('message',
							$this->config->item('success_start_delimiter', 'ion_auth')
							."Cabang Deleted!".
							$this->config->item('success_end_delimiter', 'ion_auth')
						);
					}
					else {
						$this->session->set_flashdata('message',
							$this->config->item('error_start_delimiter', 'ion_auth')
							."Cabang Delete Failed!".
							$this->config->item('error_end_delimiter', 'ion_auth')
						);
					}
				}
			}
			// Always redirect no matter what!
			redirect('cabang', 'refresh');
		}
	}
	// Delete data end
}

/* End of Cabang.php */
