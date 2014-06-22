<?php 

class Venue_model extends CI_Model {

	function getById($id) {
		$this->db->where('id', $id);
		$query = $this->db->get('venue');

		// did we find the venue
		if ($query->num_rows() == 0) {
			error_log('Could not find venue id: '.$id);
			return false;
		}

		return $query->row();
	}

	function getByName($name, $local = 'en') {
		$this->db->where('name_'.$local, $name);
		$query = $this->db->get('venue');

		// did we find the venue
		if ($query->num_rows() == 0) {
			error_log('Could not find venue with name: '.$name);
			return false;
		}

		return $query->row();
	}

	function getAllByName($lang = 'en') {
		$this->db->order_by('name_'.$lang, 'asc');
		$query = $this->db->get('venue');

		return $query->result();
	}
}