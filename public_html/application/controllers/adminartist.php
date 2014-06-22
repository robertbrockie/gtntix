<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AdminArtist extends MY_Controller {

	public function index() {
		redirect('/adminartist/all');
	}

	public function add() {

		// Create an empty artist and edit it
		$id = $this->artist_model->add();
		
		redirect('/adminartist/edit/'.$id);
	}

	public function all() {

		$data['user'] = $this->user;
		$data['artists'] = $this->artist_model->getAllByName();

		$this->load->view('/admin/include/header', $data);
		$this->load->view('/admin/include/menu', $data);
		$this->load->view('/admin/artist/list', $data);
		$this->load->view('/admin/include/footer');
	}

	public function delete($id) {
		$this->artist_model->delete($id);

		redirect('adminartist/all');
	}

	public function delete_image($id) {
		// Load Artist
		$artist = $this->artist_model->getById($id);
		$artist->image_url = '';
		$this->artist_model->update((array)$artist);
		return true;
	}

	public function edit($id) {
		$this->form_validation->set_rules('name', 'Name', 'required|callback__artist_name_exists');
		$this->form_validation->set_rules('website', 'Website', 'prep_url');
		$this->form_validation->set_rules('twitter_url', 'Twitter', 'prep_url');
		$this->form_validation->set_rules('facebook_url', 'Facebook', 'prep_url');

		if ($this->form_validation->run()) {

			$data = $this->input->post();

			$data = $this->_uploadImage('artist_image', $data);

			$id = $this->artist_model->update($data);
			redirect('/adminartist/edit/'.$id);
		}

		$data['user'] = $this->user;
		$data['artist'] = $this->artist_model->getById($id);

		$this->load->view('/admin/include/header', $data);
		$this->load->view('/admin/include/menu', $data);
		$this->load->view('/admin/artist/edit', $data);
		$this->load->view('/admin/include/footer');
	}
}
