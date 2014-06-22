<?php 

class Artist_model extends CI_Model {

	function add() {

		$data = array(
			'name' => '',
			'website' => '',
			'bio_en' => '',
			'bio_fr' => '',
			'image_url' => '',
			'twitter_url' => '',
			'facebook_url' => '',
		);

		$this->db->insert('artist', $data);

		if(mysql_affected_rows() == 1) {
			return $this->db->insert_id();
		} else { 
			return false;
		}
	}

	function delete($id) {
		$this->db->where('id', $id);
		$this->db->delete('artist');

		// delete the artist from other events
		$this->eventartist_model->deleteByArtistId($id);

		if (mysql_affected_rows() == 1) {
			return true;
		} else { 
			return false;
		}
	}

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

	function update($data) {
		$this->db->where('id', $data['id']);
		$this->db->update('artist', $data);

		return $data['id'];
	}
}