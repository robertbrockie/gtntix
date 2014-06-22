<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	const NUM_EVENTS = 48;
	const NUM_EVENTS_JUST_ANNOUNCED = 10;

	public $site_lang;
	public $website_version;

	function __construct() {
		parent::__construct();

		$this->load->model('artist_model');
		$this->load->model('calendar_model');
		$this->load->model('event_model');
		$this->load->model('eventartist_model');
		$this->load->model('venue_model');

		$this->site_lang = $this->config->item('website_lang');
		$this->website_version = $this->config->item('website_version');
	}

	/**
	*	initializeData
	*
	*	Initalize the basic data we need for the views.
	*
	*	@return An array with language, theme, etc...
	**/
	protected function initializeData() {
		$data = array();

		$data['lang'] = $this->site_lang;
		$data['image_prefix'] = $this->config->item('image_prefix');
		$data['venues'] = $this->venue_model->getAllByName();
		$data['header'] = ''; // will be overridden

		$data['website_version'] = $this->website_version;

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
	protected function renderView($view, $data) {
		$this->load->view('/include/header.html', $data);
		$this->load->view('/include/menu.html', $data);
		$this->load->view('/include/search.html', $data);
		$this->load->view('/'.$view.'.html', $data);
		$this->load->view('/include/footer.html', $data);
	}
}
