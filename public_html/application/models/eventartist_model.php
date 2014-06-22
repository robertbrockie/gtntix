<?php 

/**
*	EventArtist_model
*
*	TODO: add documentation
**/
class EventArtist_model extends CI_Model {

	function __construct() {
		parent::__construct();

		$this->load->model('artist_model');
	}

	function add($data) { 
		$this->db->insert('event_artist', $data);

		if (mysql_affected_rows() == 1) {
			return $this->db->insert_id();
		} else { 
			return false;
		}
	}

	function addHeadliner($event_id, $artist_id) {
		$this->db->where('event_id', $event_id);
		$this->db->where('artist_id', $artist_id);

		$this->db->update('event_artist', array('is_headliner' => 1));

		return true;
	}

	function delete($event_id, $artist_id) {
		$this->db->where('event_id', $event_id);
		$this->db->where('artist_id', $artist_id);

		if (mysql_affected_rows() == 1) {
			return true;
		} else { 
			return false;
		}	}

	function deleteAllByEventId($event_id) {
		$this->db->where('event_id', $event_id);
		$this->db->delete('event_artist');

		if (mysql_affected_rows() > 0) {
			return true;
		} else { 
			return false;
		}
	}

	function deleteByArtistId($artist_id) {
		$this->db->where('artist_id', $artist_id);
		$this->db->delete('event_artist');

		return true;	
	}

	function getArtistsForEventId($event_id, $filters = array()) {
		$this->db->where('event_id', $event_id);
		$this->db->order_by('rank', 'asc');

		foreach ($filters as $name => $value) {
			$this->db->where($name, $value);
		}

		$query = $this->db->get('event_artist');

		$results = $query->result();

		$event_artists = array();
		foreach ($results as $result) {
			$artist = $this->artist_model->getById($result->artist_id);
			$artist->rank = $result->rank;
			$artist->is_headliner = $result->is_headliner;

			$event_artists[] = $artist;
		}

		return $event_artists;
	}

	function getHeadlinersForEventId($event_id) {
		$filters = array('is_headliner' => 1);

		return $this->getArtistsForEventId($event_id, $filters);
	}

	function getOpenersForEventId($event_id) {
		$filters = array('is_headliner' => 0);

		return $this->getArtistsForEventId($event_id, $filters);
	}

	function getArtistForEventId($event_id, $artist_id) {
		$this->db->where('event_id', $event_id);
		$this->db->where('artist_id', $artist_id);

		$query = $this->db->get('event_artist');

		// Check if we found the event artist, if no event artist is found return the artist
		if ($query->num_rows() == 0) {

			$this->db->where('id', $artist_id);
			
			$query = $this->db->get('artist');

			if ($query->num_rows() == 0) {
				error_log('Could not find artist with id: '.$artist_id.' and event id: '.$event_id);
				return false;
			}

			$artist = $query->row();			
			$artist->rank = 0;
			$artist->is_headliner = 0;

		} else {

			$event_artist = $query->row();

			$artist = $this->artist_model->getById($artist_id);
			$artist->rank = $event_artist->rank;
			$artist->is_headliner = $event_artist->is_headliner;
		}

		return $artist;
	}

	function removeHeadliner($event_id, $artist_id) {
		$this->db->where('event_id', $event_id);
		$this->db->where('artist_id', $artist_id);

		$this->db->update('event_artist', array('is_headliner' => 0));

		return true;
	}
}