<?php 

class Event_model extends CI_Model {

	public $current_date_time;
	public $ignore_announce_date;
	public $include_non_gtn_events;


	function __construct() {
		parent::__construct();

		$this->current_date_time = date('Y-m-d H:i:s', time());

		$this->load->model('venue_model');
		$this->load->model('eventartist_model');

		$this->include_non_gtn_events = $this->config->item('include_non_gtn_events');
	}

	function initalize($ignore_announce_date = false) {
		$this->ignore_announce_date = $ignore_announce_date;
	}

	function add() {

		// Default data
		$data = array(
				'venue_id' => 0,
				'date' => '0000-00-00',
				'door_time' => '00:00:00',
				'show_time' => '00:00:00',
				'presenter_en' => '',
				'presenter_fr' => '',
				'optional_title_en' => '',
				'optional_title_fr' => '',
				'description_en' => '',
				'description_fr' => '',
				'age_restricted' => 0,
				'seated' => 0,
				'ticket_url_en' => '',
				'ticket_url_fr' => '',
				'announce_date' => '0000-00-00 00:00:00',
				'ticket_onsale_date' => '0000-00-00 00:00:00',
				'image_url' => '',
		);

		$this->db->insert('event', $data);

		if(mysql_affected_rows() == 1) {
			return $this->db->insert_id();
		} else { 
			return false;
		}
	}

	function delete($id) {
		$this->db->where('id', $id);
		$this->db->delete('event');

		if (mysql_affected_rows() == 1) {
			return true;
		} else { 
			return false;
		}
	}

	function getById($id) {
		$this->db->where('id', $id);
		$query = $this->db->get('event');

		// did we find the artist
		if ($query->num_rows() == 0) {
			error_log('Could not find artist id: '.$id);
			return false;
		}

		$event = $query->row();

		// set the venue name on the event object
		$venue = $this->venue_model->getById($event->venue_id);

		if ($venue) {
			$event->venue_name = $venue->name_en;
		} else {
			$event->venue_name = '';
		}

		return $event;
	}

	function getAll($filter_non_gtn_events = true) {
		$this->db->order_by('date', 'desc');
		$this->db->select('id');
		if ($filter_non_gtn_events) {
			$this->db->where('non_gtn_event', 0);
		}

		if (!$this->ignore_announce_date) {
			$this->db->where('announce_date <= ', $this->current_date_time);
		}

		$query = $this->db->get('event');

		$results = $query->result();

		$events = array();
		foreach ($results as $result) {
			$events[] = $this->getById($result->id);
		}
		
		return $events;
	}

	function getAllByVenueId($venue_id) {
		$this->db->order_by('date', 'desc');
		$this->db->select('id');
		$this->db->where('venue_id', $venue_id);
		if (!$this->include_non_gtn_events) {
			$this->db->where('non_gtn_event', 0);
		}

		if (!$this->ignore_announce_date) {
			$this->db->where('announce_date <= ', $this->current_date_time);
		}

		$query = $this->db->get('event');

		$results = $query->result();

		$events = array();
		foreach ($results as $result) {
			$events[] = $this->getById($result->id);
		}

		return $events;
	}

	function getMonthEvents($year, $month) {
		$this->db->select('id');
		if (!$this->include_non_gtn_events) {
			$this->db->where('non_gtn_event', 0);
		}
		$this->db->like('date', $year.'-'.$month, 'after');

		if (!$this->ignore_announce_date) {
			$this->db->where('announce_date <= ', $this->current_date_time);
		}

		$query = $this->db->get('event');

		$results = $query->result();

		$events = array();
		foreach ($results as $result) {
			$events[] = $this->getById($result->id);
		}

		return $events;
	}

	function getLatestEvents($limit = 1) {
		$this->db->order_by('date', 'asc');
		$this->db->select('id');
		$this->db->where('date >= ', date('Y-m-d'));
		if (!$this->include_non_gtn_events) {
			$this->db->where('non_gtn_event', 0);
		}

		if (!$this->ignore_announce_date) {
			$this->db->where('announce_date <= ', $this->current_date_time);
		}

		$query = $this->db->get('event', $limit);

		$results = $query->result();

		$events = array();
		foreach ($results as $result) {
			$events[] = $this->getById($result->id);
		}

		return $events;
	}

	function getJustAnnouncedEvents($limit = 1) {
		$this->db->order_by('announce_date', 'desc');
		$this->db->select('id');
		if (!$this->include_non_gtn_events) {
			$this->db->where('non_gtn_event', 0);
		}
		$this->db->where('announce_date <= ', $this->current_date_time);

		$query = $this->db->get('event', $limit);

		$results = $query->result();

		$events = array();
		foreach ($results as $result) {
			$events[] = $this->getById($result->id);
		}

		return $events;
	}

	function getByVenueId($venue_id) {
		$this->db->order_by('date', 'asc');
		$this->db->select('id');
		$this->db->where('date >= ', date('Y-m-d'));
		$this->db->where('venue_id', $venue_id);
		if (!$this->include_non_gtn_events) {
			$this->db->where('non_gtn_event', 0);
		}

		if (!$this->ignore_announce_date) {
			$this->db->where('announce_date <= ', $this->current_date_time);
		}

		$query = $this->db->get('event');

		$results = $query->result();

		$events = array();
		foreach ($results as $result) {
			$events[] = $this->getById($result->id);
		}

		return $events;
	}

	function search($keyword) {
		if ($this->include_non_gtn_events) {
			$query = $this->db->query('SELECT DISTINCT e.id as id FROM event as e, event_artist as ea, artist as a, venue as v WHERE e.id = ea.event_id and ea.artist_id = a.id and e.venue_id = v.id and e.date >= "'.date('Y-m-d').'" and announce_date <= "'.$this->current_date_time.'" and (a.name like "%'.$this->db->escape_like_str($keyword).'%" or v.name_en like "%'.$this->db->escape_like_str($keyword).'%" or v.name_fr like "%'.$this->db->escape_like_str($keyword).'%") ORDER BY e.date DESC');
		} else {
			$query = $this->db->query('SELECT DISTINCT e.id as id FROM event as e, event_artist as ea, artist as a, venue as v WHERE e.id = ea.event_id and ea.artist_id = a.id and e.venue_id = v.id and e.date >= "'.date('Y-m-d').'" and announce_date <= "'.$this->current_date_time.'" and non_gtn_event = 0 and (a.name like "%'.$this->db->escape_like_str($keyword).'%" or v.name_en like "%'.$this->db->escape_like_str($keyword).'%" or v.name_fr like "%'.$this->db->escape_like_str($keyword).'%") ORDER BY e.date DESC');
		}

		$results = $query->result();
		
		$events = array();
		foreach ($results as $result) {
			$events[] = $this->getById($result->id);
		}

		return $events;
	}

	function update($data) {

		// TODO: whats the proper way of handling attached
		// attributes in CI, this can't be the best.
		if (isset($data['venue_name'])) {
			unset($data['venue_name']);
		}
		$this->db->where('id', $data['id']);
		$this->db->update('event', $data);

		return $data['id'];
	}
}
