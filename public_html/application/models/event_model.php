<?php 

class Event_model extends CI_Model {

	public $current_date_time;
	public $promoter_id;

	function __construct() {
		parent::__construct();

		$this->current_date_time = date('Y-m-d H:i:s', time());

		$this->load->model('venue_model');
		$this->load->model('eventartist_model');

		$this->promoter_id = $this->config->item('promoter_id');
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

	function getAllByVenueId($venue_id) {
		$this->db->order_by('date', 'desc');
		$this->db->select('id');
		$this->db->where('venue_id', $venue_id);
		$this->db->where('announce_date <= ', $this->current_date_time);

		$query = $this->db->get('event');

		$results = $query->result();

		return $this->getByRowIds($results);
	}

	function getFeaturedEvents() {
		$this->db->order_by('date', 'asc');
		$this->db->join('event_promoter', 'event.id = event_promoter.event_id');

		$this->db->select('event.id');
		$this->db->where('event_promoter.promoter_id =', $this->promoter_id);
		$this->db->where('event_promoter.featured', 1);
		$this->db->where('date >= ', date('Y-m-d'));
		$this->db->where('announce_date <= ', $this->current_date_time);

		$query = $this->db->get('event');

		$results = $query->result();

		return $this->getByRowIds($results);
	}

	function getMonthEvents($year, $month) {
		$this->db->join('event_promoter', 'event.id = event_promoter.event_id');

		$this->db->select('event.id');
		$this->db->where('event_promoter.promoter_id =', $this->promoter_id);
		$this->db->like('date', $year.'-'.$month, 'after');
		$this->db->where('announce_date <= ', $this->current_date_time);

		$query = $this->db->get('event');

		$results = $query->result();

		return $this->getByRowIds($results);
	}

	function getLatestEvents($limit = 1) {
		$this->db->order_by('date', 'asc');
		$this->db->join('event_promoter', 'event.id = event_promoter.event_id');

		$this->db->select('event.id');
		$this->db->where('event_promoter.promoter_id =', $this->promoter_id);
		$this->db->where('date >= ', date('Y-m-d'));
		$this->db->where('announce_date <= ', $this->current_date_time);

		$query = $this->db->get('event', $limit);

		$results = $query->result();

		return $this->getByRowIds($results);
	}

	function getJustAnnouncedEvents($limit = 1) {
		$this->db->order_by('announce_date', 'desc');
		$this->db->join('event_promoter', 'event.id = event_promoter.event_id');

		$this->db->select('event.id');
		$this->db->where('event_promoter.promoter_id =', $this->promoter_id);
		$this->db->where('announce_date <= ', $this->current_date_time);
		$this->db->where('date >= ', date('Y-m-d'));

		$query = $this->db->get('event', $limit);

		$results = $query->result();

		return $this->getByRowIds($results);
	}

	function getByVenueId($venue_id) {
		$this->db->order_by('date', 'asc');
		$this->db->join('event_promoter', 'event.id = event_promoter.event_id');

		$this->db->select('event.id');
		$this->db->where('event_promoter.promoter_id =', $this->promoter_id);
		$this->db->where('date >= ', date('Y-m-d'));
		$this->db->where('venue_id', $venue_id);
		$this->db->where('announce_date <= ', $this->current_date_time);

		$query = $this->db->get('event');

		$results = $query->result();

		return $this->getByRowIds($results);
	}

	function search($keyword) {
		$query = $this->db->query('SELECT DISTINCT e.id as id FROM event as e, event_artist as ea, artist as a, event_promoter as ep, venue as v WHERE e.id = ea.event_id and ea.artist_id = a.id and e.venue_id = v.id and e.id = ep.event_id and ep.promoter_id = "'.$this->promoter_id.'" and e.date >= "'.date('Y-m-d').'" and announce_date <= "'.$this->current_date_time.'" and (a.name like "%'.$this->db->escape_like_str($keyword).'%" or v.name_en like "%'.$this->db->escape_like_str($keyword).'%" or v.name_fr like "%'.$this->db->escape_like_str($keyword).'%") ORDER BY e.date DESC');

		$results = $query->result();
		
		return $this->getByRowIds($results);
	}

	/**
	*	getByRowIds
	*
	*	Get events from a list of rows with ids.
	*
	*	@param ids - The rows of ids for the events we want to get.
	**/
	private function getByRowIds($rows) {
		$events = array();
		foreach ($rows as $row) {
			$events[] = $this->getById($row->id);
		}

		return $events;
	}
}