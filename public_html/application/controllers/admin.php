<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	public $user;

	function __construct() {

		parent::__construct();

		$this->load->model('user_model');
	}

	public function index() {
		
		// logged in?
		if (!$this->session->userdata('logged_in')) {
			redirect('/admin/login');
		}

		redirect('/admin/actions');

	}

	public function login() {
		$this->form_validation->set_rules('username', 'Username', 'trim|required|callback__check_username_password');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if ($this->form_validation->run()) {
			$user = $this->user_model->getUser($this->input->post('username'), $this->input->post('password'));
			$this->user = $user;
	
			if ($user) {
				$this->session->set_userdata('logged_in', true);
				$this->session->set_userdata('user', $user);
				redirect('/admin/actions');
			}
			
			$this->form_validation->set_message('', 'Invalid username or password');
		}
		
		$this->load->view('/admin/include/header');
		$this->load->view('/admin/login');
		$this->load->view('/admin/include/footer');
	}

	public function logout() {
		$this->session->sess_destroy();
		redirect('/admin/login');
	}

	public function actions() {
		//make sure the user is logged in
		if (!$this->session->userdata('logged_in')) {
			redirect('/admin/login');
		}

		$data['user'] = $this->user = $this->session->userdata('user');

		$this->load->view('/admin/include/header', $data);
		$this->load->view('/admin/include/menu', $data);
		$this->load->view('/admin/actions');
		$this->load->view('/admin/include/footer');
	}

	function _check_username_password($username) {
		if($this->input->post('password')) {
			$user = $this->user_model->getUser($this->input->post('username'), $this->input->post('password'));

			if($user) {
				return true;
			}

			$this->form_validation->set_message('_check_username_password', 'Username and password are incorrect.');
			return false;
		}
	}
}
