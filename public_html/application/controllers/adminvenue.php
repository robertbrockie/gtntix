<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AdminVenue extends MY_Controller {

	public function index() {
		redirect('/adminvenue/all');
	}

	public function add() {
		
		// Create empty venue and edit it
		$id = $this->venue_model->add($this->input->post());
		
		redirect('/adminvenue/edit/'.$id);
	}

	public function all() {
		$data['user'] = $this->user;
		$data['venues'] = $this->venue_model->getAllByName();

		$this->load->view('/admin/include/header', $data);
		$this->load->view('/admin/include/menu', $data);
		$this->load->view('/admin/venue/list', $data);
		$this->load->view('/admin/include/footer');
	}

	public function delete($id) {
		$this->venue_model->delete($id);

		redirect('/adminvenue/all');
	}

	public function edit($id) {
		$this->form_validation->set_rules('address_en', 'Address (english)', 'required');
		$this->form_validation->set_rules('name_fr', 'Name (french)', 'required');
		$this->form_validation->set_rules('address_fr', 'Address (french)', 'required');
		$this->form_validation->set_rules('map_url', 'Map URL', 'required|prep_url');
		$this->form_validation->set_rules('website', 'Website', 'required|prep_url');

		if ($this->form_validation->run()) {
			$id = $this->venue_model->update($this->input->post());
			redirect('/adminvenue/edit/'.$id);
		}

		$data['user'] = $this->user;
		$data['venue'] = $this->venue_model->getById($id);

		$this->load->view('/admin/include/header', $data);
		$this->load->view('/admin/include/menu', $data);
		$this->load->view('/admin/venue/edit', $data);
		$this->load->view('/admin/include/footer');
	}
}
