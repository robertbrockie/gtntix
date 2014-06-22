<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Event extends MY_Controller {

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