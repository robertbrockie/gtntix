<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Event extends CI_Controller {

	const NUM_EVENTS = 48;
	const NUM_EVENTS_JUST_ANNOUNCED = 10;

	public $site_lang;

	function __construct() {
		parent::__construct();

		$this->load->model('artist_model');
		$this->load->model('calendar_model');
		$this->load->model('event_model');
		$this->load->model('eventartist_model');
		$this->load->model('venue_model');

		$this->site_lang = $this->config->item('website_lang');
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

		$data['lang'] = $this->site_lang;
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
		$data['header'] = 'upcoming_events';

		// get all events
		$data['events'] = $this->event_model->getLatestEvents(self::NUM_EVENTS);

		$data['event_artists'] = array();
		foreach ($data['events'] as $event) {
			$data['event_artists'][$event->id]['headliners'] = $this->eventartist_model->getHeadlinersForEventId($event->id);
			$data['event_artists'][$event->id]['openers'] = $this->eventartist_model->getOpenersForEventId($event->id);
		}

		// get just announced events
		$data['just_announced_events'] = $this->event_model->getJustAnnouncedEvents(self::NUM_EVENTS_JUST_ANNOUNCED);
		foreach ($data['just_announced_events'] as $event) {
			$event_artists = $this->eventartist_model->getArtistsForEventId($event->id);

			if (count($event_artists) > 0) {
				$data['just_announced_event_artists'][$event->id] = array($event_artists[0]);
			}
		}

		$this->renderView('event_list', $data);
	}

	public function view($id) {

		$data = $this->initializeData();

		$data['header'] = '';

		$data['event'] = $this->event_model->getById($id);
		$data['event_artists'] = $this->eventartist_model->getArtistsForEventId($id);

		$data['venue'] = $this->venue_model->getById($data['event']->venue_id);

		$this->renderView('event_view', $data);
	}

	public function calendar($year = null, $month = null) {

		$data = $this->initializeData();

		$data['header'] = 'event_calendar';

		$data['calendar'] = $this->calendar_model->generate($year, $month);

		$this->renderView('calendar_view', $data);
	}

	public function search() {

		$data = $this->initializeData();

		$data['header'] = 'search_results';

		$keyword = $this->input->post('keyword');

		$data['events'] = $this->event_model->search($keyword);

		$data['event_artists'] = array();
		foreach ($data['events'] as $event) {
			$data['event_artists'][$event->id]['headliners'] = $this->eventartist_model->getHeadlinersForEventId($event->id);
			$data['event_artists'][$event->id]['openers'] = $this->eventartist_model->getOpenersForEventId($event->id);
		}

		$this->renderView('event_list', $data);
	}
}