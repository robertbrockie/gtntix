<?php 

class Artist_model extends CI_Model {

	function getById($id) {
		$this->db->where('id', $id);
		$query = $this->db->get('artist');

		// did we find the artist
		if ($query->num_rows() == 0) {
			error_log('Could not find artist id: '.$id);
			return false;
		}

		return $query->row();
	}

	function getByName($name) {
		$this->db->where('name_', $name);
		$query = $this->db->get('artist');

		// did we find the artist
		if ($query->num_rows() == 0) {
			error_log('Could not find artist with name: '.$name);
			return false;
		}

		return $query->row();
	}

	function getAll() {
		$query = $this->db->get('artist');

		return $query->result();
	}

	function getAllByName() {
		$this->db->order_by('name', 'asc');
		$query = $this->db->get('artist');

		return $query->result();
	}
}