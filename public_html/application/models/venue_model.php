<?php 

class Venue_model extends CI_Model {

	function add() {

		$data = array(
			'name_en' => '',
			'name_fr' => '',
			'address_en' => '',
			'address_fr' => '',
			'map_url' => '',
			'website' => '',
		);

		$this->db->insert('venue', $data);

		if(mysql_affected_rows() == 1) {
			return $this->db->insert_id();
		} else { 
			return false;
		}
	}

	function delete($id) {
		$this->db->where('id', $id);
		$this->db->delete('venue');

		if (mysql_affected_rows() == 1) {
			return true;
		} else { 
			return false;
		}
	}

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

	function getAll() {
		$query = $this->db->get('venue');

		return $query->result();
	}

	function getAllByName($lang = 'en') {
		$this->db->order_by('name_'.$lang, 'asc');
		$query = $this->db->get('venue');

		return $query->result();
	}

	function update($data) {
		$this->db->where('id', $data['id']);
		$this->db->update('venue', $data);

		return $data['id'];
	}
}