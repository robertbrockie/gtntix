<?php

class User_model extends CI_Model {

	function getUser($username, $password) {
		$this->db->where('username', $username);
		$this->db->where('password', $password);

		$query = $this->db->get('user');

		//did we find the user
		if ($query->num_rows() == 0) {
			error_log('Could not find user');
			return false;
		}

		return $query->row();
	}
}