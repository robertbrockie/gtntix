<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Venue extends MY_Controller {

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

		$data['event'] = $this->event_model->getById($id);
		$data['event_artists'] = $this->eventartist_model->getArtistsForEventId($id);

		$this->renderView('event_view', $data);
	}
}