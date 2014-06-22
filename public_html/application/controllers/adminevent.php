<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AdminEvent extends MY_Controller {

	public function index() {
		redirect('/adminevent/all');
	}

	public function add() {

		// Create an empty event then edit it
		$id = $this->event_model->add();

		redirect('/adminevent/edit/'.$id);
	}

	public function add_artist($event_id, $artist_id) {
		$data = array(
				'event_id' => $event_id,
				'artist_id' => $artist_id,
				'rank' => 0,
				'is_headliner' => 0,
		);
		$this->eventartist_model->add($data);
	}

	public function add_headliner($event_id, $artist_id) {
		$this->eventartist_model->addHeadliner($event_id, $artist_id);
	}

	public function all() {
		$data['user'] = $this->user;

		// Filter events if user is a venue
		if (user_is_not_venue($this->user)) {
			$data['events'] = $this->event_model->getAll(false);
		} else {
			$data['events'] = $this->event_model->getAllByVenueId($this->user->venue_id);
		}

		$data['events_artists'] = array();

		foreach ($data['events'] as $event) {

			$data['events_artists'][$event->id] = '';

			$artists = $this->eventartist_model->getArtistsForEventId($event->id);

			foreach($artists as $artist) {
				$data['events_artists'][$event->id] .= $artist->name.', ';	
			}
			$data['events_artists'][$event->id] = rtrim($data['events_artists'][$event->id], ', '); //trim the last ', '

		}

		$this->load->view('/admin/include/header', $data);
		$this->load->view('/admin/include/menu', $data);
		$this->load->view('/admin/event/list', $data);
		$this->load->view('/admin/include/footer');
	}

	public function delete($id) {
		$this->event_model->delete($id);
		$this->eventartist_model->deleteAllByEventId($id);

		redirect('/adminevent/all/');
	}

	public function delete_image($id) {
		// Load Artist
		$event = $this->event_model->getById($id);
		$event->image_url = '';
		$this->event_model->update((array)$event);
		return true;
	}

	public function edit($id) {
		$this->form_validation->set_rules('date', 'Event Date', 'required');
		$this->form_validation->set_rules('venue_id', 'Venue', 'require');
		$this->form_validation->set_rules('ticket_url_en', 'Ticket URL (en)', 'prep_url');
		$this->form_validation->set_rules('ticket_url_fr', 'Ticket URL (fr)', 'prep_url');

		if (user_is_venue($this->user)) {
			$this->form_validation->set_rules('venue_event', 'Venue Event Error', 'callback__check_venue_event_edit');
		}

		$event_artists = array();
		$event_artist_ids = array();
		$event_artist_ids_with_headliner = array();

		// Get the artists for this event
		if ($this->input->post('event_artists')) {
			$event_artist_ids = $this->input->post('event_artists');

			foreach ($event_artist_ids as $event_artist_id) {

				// Get the artists for this event
				$event_artist = $this->eventartist_model->getArtistForEventId($id, $event_artist_id);
				$event_artists[] = $event_artist;
				$event_artist_ids_with_headliner[$event_artist_id] = $event_artist->is_headliner;
			}
		} else {
			$event_artists = $this->eventartist_model->getArtistsForEventId($id);
		}

		// Validate the data
		if ($this->form_validation->run()) {

			$data = $this->input->post();

			// Handle the checkboxes
			$checkboxes = array('non_gtn_event', 'age_restricted', 'seated');
			foreach ($checkboxes as $checkbox) {
				if (isset($data[$checkbox])) {
					$data[$checkbox] = 1;
				} else {
					$data[$checkbox] = 0;
				}
			}

			// Upload an event photo
			$data = $this->_uploadImage('event_image', $data);
			
			// Unset the event artists, we'll handle that later
			unset($data['event_artists']);

			$this->event_model->update($data);

			// Remove all current artists and we'll just add the new ones
			$this->eventartist_model->deleteAllByEventId($id);

			// Add artists to event
			$rank = 0;
			//die('<pre>'.print_r($event_artist_ids_with_headliner, true));
			foreach ($event_artist_ids as $event_artist_id) {
				$event_artist_data = array();
				$event_artist_data['event_id'] = $id;
				$event_artist_data['artist_id'] = $event_artist_id;
				$event_artist_data['rank'] = $rank;
				$event_artist_data['is_headliner'] = $event_artist_ids_with_headliner[$event_artist_id];

				$this->eventartist_model->add($event_artist_data);
				$rank++;
			}

			redirect('/adminevent/edit/'.$id);
		}

		$data['user'] = $this->user;
		$data['artists'] = $this->artist_model->getAllByName();
		$data['event'] = $this->event_model->getById($id);
		$data['event_artists'] = $event_artists;

		// Venue users will only have thier venue as an option
		if (user_is_venue($this->user)) {
			$data['venues'] = array($this->venue_model->getById($this->user->venue_id));
		} else {
			$data['venues'] = $this->venue_model->getAll();
		}
		

		$this->load->view('/admin/include/header', $data);
		$this->load->view('/admin/include/menu', $data);
		$this->load->view('/admin/event/edit', $data);
		$this->load->view('/admin/include/footer');
	}

	public function remove_headliner($event_id, $artist_id) {
		$this->eventartist_model->removeHeadliner($event_id, $artist_id);	
	}

	function _check_venue_event_edit() {
		if($this->input->post('venue_id') == $this->user->venue_id) {
			return true;
		} else {
			$this->form_validation->set_message('_check_venue_event_edit', 'Venue cannot create events for other venues.');
			return false;
		}
	}
}