<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	public $user;

	function __construct() {
		parent::__construct();

		// always check to see if the current user is logged in
		if (!$this->session->userdata('logged_in') || !$this->session->userdata('user')) {
			redirect('/admin/login');
		}

		$this->user = $this->session->userdata('user');

		$this->load->model('artist_model');
		$this->load->model('event_model');
		$this->event_model->initalize(true);
		$this->load->model('eventartist_model');
		$this->load->model('venue_model');
	}

	function _check_artist_name_exists($name) {
		if($this->artist_model->getByName($name)) {
			$this->form_validation->set_message('_check_artist_name_exists', 'Artist already exists.');
			return false;
		}
		
		return true;
	}

	function _check_venue_name_exists($name) {
		if($this->venue_model->getByName($name)) {
			$this->form_validation->set_message('_check_venue_name_exists', 'Venue already exists.');
			return false;
		}
		
		return true;
	}

	/**
	*	_uploadImage
	*
	*	@param field_name - The field name of the image
	*	@param data - The data used to represent the object
	*
	*	Upload a photo and set the url.
	**/
	public function _uploadImage($field_name, $data) {

		if (isset($_FILES[$field_name])) {

			$config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|jpeg|png'; 
			$config['max_size'] = '1024'; // 1 meg
			$config['remove_spaces'] = true;
			$this->load->library('upload', $config);

			if (!$this->upload->do_upload($field_name)) {
				error_log('Error uploading image: '.$this->upload->display_errors());
			} else {
				$upload_data = $this->upload->data();
				$data['image_url'] = $upload_data['file_name'];
			}
		}

		return $data;
	}
}