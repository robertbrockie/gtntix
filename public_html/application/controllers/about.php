<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class About extends CI_Controller {

	function __construct() {
		parent::__construct();

		$this->load->model('venue_model');
	}

	/**
	*	initializeData
	*
	*	Initalize the basic data we need for the views.
	*
	*	@return An array with language, theme, etc...
	**/
	private function initializeData() {
		$data = array();

		$data['lang'] = $this->config->item('website_lang');
		$data['image_prefix'] = $this->config->item('image_prefix');
		$data['venues'] = $this->venue_model->getAllByName();

		return $data;
	}

	/**
	*	renderView
	*
	*	Render the common views, along with the specific view.
	*
	*	@param $view - The specific view you want rendered.
	*	@param $data - The data required for the view.
	**/
	private function renderView($view, $data) {
		$this->load->view('/include/'.$data['lang'].'/header.html', $data);
		$this->load->view('/include/'.$data['lang'].'/menu.html', $data);
		$this->load->view('/include/'.$data['lang'].'/search.html', $data);
		$this->load->view('/'.$data['lang'].'/'.$view.'.html', $data);
		$this->load->view('/include/'.$data['lang'].'/footer.html', $data);
	}

	public function index() {
		$data = $this->initializeData();

		switch ($data['lang']) {
			case 'fr':
				$data['header'] = 'À propos';
				break;
			default:
				$data['header'] = 'About';
		}

		$this->renderView('about', $data);
	}
}