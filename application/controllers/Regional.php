<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*	Regional Controller
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
class Regional extends CI_Controller {

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
			redirect('auth/login/regional', 'refresh');
		}
		// Logged in
		else{
			$this->data['cabang_list'] = $this->cabang_model->get_cabang("", "1");
			$this->data['data_list']   = $this->regional_model->get_regional_pagination();

			// Set pagination
			$config['base_url']         = base_url('regional/index');
			$config['use_page_numbers'] = TRUE;
			$config['total_rows']       = count($this->data['data_list']->result());
			$config['per_page']         = 15;
			$this->pagination->initialize($config);

			// Get datas and limit based on pagination settings
			if ($page=="") { $page = 1; }
			$this->data['data_list'] = $this->regional_model->get_regional_pagination("",
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
			$this->load->view('regional/index');
			$this->load->view('partials/_alte_footer');
			$this->load->view('regional/js');
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
			redirect('auth/login/regional', 'refresh');
		}
		// Logged in
		else {
			// input validation rules
			$this->form_validation->set_rules('nama', 'Nama Regional', 'trim|addslashes|strip_tags|required|callback__name_check');
			$this->form_validation->set_rules('cabang_id', 'Cabang', 'trim|addslashes|strip_tags|required');

			// check if there's valid input
			if (isset($_POST) && !empty($_POST)) {
				// validation run
				if ($this->form_validation->run() === TRUE) {
					$data = array(
						'nama'      => $this->input->post('nama'),
						'cabang_id' => $this->input->post('cabang_id'),
						'aktif'     => '1',
					);

					// check to see if we are inserting the data
					if ($this->regional_model->insert_regional($data)) {
						$this->session->set_flashdata('message',
							$this->config->item('success_start_delimiter', 'ion_auth')
							."Data regional berhasil disimpan".
							$this->config->item('success_end_delimiter', 'ion_auth')
						);
					}
					else {
						$this->session->set_flashdata('message',
							$this->config->item('error_start_delimiter', 'ion_auth')
							."Data regional gagal disimpan".
							$this->config->item('error_end_delimiter', 'ion_auth')
						);
					}
					redirect('regional', 'refresh');
				}

        // $this->session->set_flashdata('message',
        //   $this->config->item('error_start_delimiter', 'ion_auth')
        //   ."Data regional dikirim namun gagal disimpan".
        //   $this->config->item('error_end_delimiter', 'ion_auth')
        // );
        // redirect('regional', 'refresh');
      }

			$this->data['cabang_list'] = $this->cabang_model->get_cabang("", "1");
			$this->data['data_list']   = $this->regional_model->get_regional_pagination();
			$this->data['open_form']   = "open";

			// Set pagination
			$config['base_url']         = base_url('regional/index');
			$config['use_page_numbers'] = TRUE;
			$config['total_rows']       = count($this->data['data_list']->result());
			$config['per_page']         = 15;
			$this->pagination->initialize($config);

			// Get datas and limit based on pagination settings
			$page = 1;
			$this->data['data_list'] = $this->regional_model->get_regional_pagination("",
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
			$this->load->view('regional/index');
			$this->load->view('partials/_alte_footer');
			$this->load->view('regional/js');
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
		$datas = $this->regional_model->name_check($name);
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
			redirect('auth/login/regional', 'refresh');
		}
		// Logged in
		else {
			// input validation rules
			$this->form_validation->set_rules('nama', 'Nama Regional', 'trim|strip_tags|addslashes|required');

			// check if there's valid input
			if (isset($_POST) && !empty($_POST)) {
				// validation run
				if ($this->form_validation->run() === TRUE) {
					$data = array(
            'nama'  => $this->input->post('nama'),
						'slug'  => str_replace(" ", "-", strtolower($this->input->post('nama'))),
					);

					// check to see if we are updating the data
					if ($this->regional_model->update_regional($id, $data)) {
						$this->session->set_flashdata('message',
							$this->config->item('success_start_delimiter', 'ion_auth')
							."Regional berhasil diubah!".
							$this->config->item('success_end_delimiter', 'ion_auth')
						);
					}
					else {
						$this->session->set_flashdata('message',
							$this->config->item('error_start_delimiter', 'ion_auth')
							."Regional gagal diubah!".
							$this->config->item('error_end_delimiter', 'ion_auth')
						);
					}
					redirect('regional', 'refresh');
				}
			}
			// Get data
			$this->data['cabang_list'] = $this->cabang_model->get_cabang("", "1");
			$this->data['data_list']   = $this->regional_model->get_regional_pagination($id);
			$this->data['id']          = $id;

			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() :
			$this->session->flashdata('message');

			$this->load->view('partials/_alte_header', $this->data);
			$this->load->view('partials/_alte_menu');
			$this->load->view('regional/edit');
			$this->load->view('partials/_alte_footer');
			$this->load->view('regional/js');
			$this->load->view('js_script');
		}
	}
	// Edit data end

	/**
	*	Delete Data
	*	If there's data sent, update deleted
	*	Else, redirect to regional
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
			redirect('auth/login/regional', 'refresh');
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
					if ($this->regional_model->update_regional($id, $data)) {
						$this->session->set_flashdata('message',
							$this->config->item('success_start_delimiter', 'ion_auth')
							."Regional berhasil dihapus!".
							$this->config->item('success_end_delimiter', 'ion_auth')
						);
					}
					else {
						$this->session->set_flashdata('message',
							$this->config->item('error_start_delimiter', 'ion_auth')
							."Regional gagal dihapus!".
							$this->config->item('error_end_delimiter', 'ion_auth')
						);
					}
				}
			}
			// Always redirect no matter what!
			redirect('regional', 'refresh');
		}
	}
	// Delete data end


	/**
	*	Data regional select
	*	Sebagai sumber data untuk pilihan regional berdasarkan cabang
	*	Mengembalikan hasil string HTML Select
	*
	*	@param 		string
	*	@return 	string
	*
	*/
	public function data_regional($no_function="")
	{
		// Jika tidak login, kembalikan ke halaman utama
		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login', 'refresh');
		}

		$cabang = $this->input->get('cabang');

		if ($cabang != "" && $cabang != " ") {
			$datas = $this->regional_model->get_regional_by_cabang($cabang);
			if (count($datas->result())>0) {
				$result = '<select name="regional_id" id="regional_id" class="form-control select2" style="width:100%" onchange="tampilkan_toko_regional(this.value)">';

				// jika tanpa fungsi
				if ($no_function!="") {
					$result = '<select name="regional_id" id="regional_id" class="form-control select2" style="width:100%">';
				}

				$result .= "<option value=''>- Pilih Regional -</option>";
				foreach ($datas->result() as $data) {
					$result .= "<option value=".$data->id.">".$data->nama . "</option>";
				}
				$result .= '</select>';
			}
			else {
				$result = "<p class='form-control-static text-danger'>Tidak ada regional dalam cabang ini!</p>";
				$result .= "<input type='hidden' name='regional_id' id='regional_id' value='' >";
			}
		}
		else {
			$result = "Harap pilih cabang terlebih dulu.";
			$result .= "<input type='hidden' name='regional_id' id='regional_id' value='' >";
		}

		echo $result;
	}

	/**
	*	Data regional checkbox
	*	Sebagai sumber data untuk pilihan regional berdasarkan cabang
	*	Mengembalikan hasil string HTML Checkbox
	*
	*	@return 	string
	*
	*/
	public function data_regional_checkbox()
	{
		// Jika tidak login, kembalikan ke halaman utama
		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login', 'refresh');
		}

		$cabang = $this->input->get('cabang');

		if ($cabang != "" && $cabang != " ") {
			$datas = $this->regional_model->get_regional_by_cabang($cabang);
			if (count($datas->result())>0) {
				$result = "";
				// Jika data lebih besar dari 3, maka buat menjadi 2 kolom
				if (count($datas->result())>3) {
					$batas = ceil(count($datas->result())/2);
					$xs    = 0;
					$result .= "<div class='row'>";
					foreach ($datas->result() as $dls){
						// Flagging untuk menentukan jumlah data
						$xs++;
						// Jika 1, col 1.
						if ($xs==1) {
							$result .= "<div class='col-md-6'>";
							// Select all
							$result .= '<div class="radio">
								<label for="regional_id_all">
									<input type="checkbox" id="regional_id_all" class="regional_cb pilih_semua" value=""> Pilih Semua
								</label>
							</div>';
						}
						// Jika sudah batas, col 2
						elseif($xs==$batas+1) {
							$result .= "</div>";
							$result .= "<div class='col-md-6'>";
						}
						$result .= '<div class="radio">
							<label for="regional_id_'.$dls->id.'">
								<input type="checkbox" name="regional_id[]" id="regional_id_'.$dls->id.'" class="regional_cb" value="'.$dls->id.'" '.set_checkbox('regional_id[]', $dls->id).'> '.$dls->nama.'
							</label>
						</div>';
					}
					$result .= "</div> <!-- End col-6 -->";
					$result .= "</div> <!-- End row -->";
				}
				// Jika data masih 3 kebawah
				elseif (count($datas->result())>0 && count($datas->result())<=3) {
					// $result .= '<div class="col-md-12">';
						$xs = 0;
						// Select all
						$result .= '<div class="radio">
							<label for="regional_id_all">
								<input type="checkbox" id="regional_id_all" class="regional_cb pilih_semua" value=""> Pilih Semua
							</label>
						</div>';
						foreach ($datas->result() as $dls){
							$xs++;
							$result .= '<div class="radio">
								<label for="regional_id_'.$dls->id.'">
									<input type="checkbox" name="regional_id[]" id="regional_id_'.$dls->id.'" class="regional_cb" value="'.$dls->id.'" '.set_checkbox("regional_id[]", $dls->id).'> '.$dls->nama.'
								</label>
							</div>';
						}
					// $result .= '</div>';
				}
				else {
					$result = "<p class='form-control-static text-danger'>Tidak ada regional dalam cabang ini!</p>";
					$result .= "<input type='hidden' name='regional_id[]' id='regional_id' value='' >";
				}
			}
			else {
				$result = "<p class='form-control-static text-danger'>Tidak ada regional dalam cabang ini!</p>";
				$result .= "<input type='hidden' name='regional_id[]' id='regional_id' value='' >";
			}
		}
		else {
			$result = "Harap pilih cabang terlebih dulu.";
			$result .= "<input type='hidden' name='regional_id' id='regional_id' value='' >";
		}

		echo $result;
	}


}

/* End of Regional.php */
