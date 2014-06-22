<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Venue extends CI_Controller {

	function __construct() {
		parent::__construct();

		$this->load->model('artist_model');
		$this->load->model('calendar_model');
		$this->load->model('event_model');
		$this->load->model('eventartist_model');
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
		$this->load->view('/include/header.html', $data);
		$this->load->view('/include/'.$data['lang'].'/menu.html', $data);
		$this->load->view('/include/'.$data['lang'].'/search.html', $data);
		$this->load->view('/'.$data['lang'].'/'.$view.'.html', $data);
		$this->load->view('/include/footer.html', $data);
	}

	public function events($id) {

		$data = $this->initializeData();

		// Load the venue
		$venue = $this->venue_model->getById($id);

		switch ($data['lang']) {
			case 'fr':
				$data['header'] = $venue->name_fr;
				break;
			default: 
				$data['header'] = $venue->name_en;
		}

		$data['events'] = $this->event_model->getByVenueId($id);

		$data['event_artists'] = array();
		foreach ($data['events'] as $event) {
			$data['event_artists'][$event->id]['headliners'] = $this->eventartist_model->getHeadlinersForEventId($event->id);
			$data['event_artists'][$event->id]['openers'] = $this->eventartist_model->getOpenersForEventId($event->id);
		}

		$this->renderView('event_list', $data);
	}

	public function view($id) {

		$data = $this->initializeData();

		$data['header'] = '';

		$data['event'] = $this->event_model->getById($id);
		$data['event_artists'] = $this->eventartist_model->getArtistsForEventId($id);

		$this->renderView('event_view', $data);
	}
}