<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
*
*	user_helper
*
**/
if (!function_exists('user_is_venue')) {

	function user_is_venue($user) {

		return $user->venue_id > 0;
	}
}

if (!function_exists('user_is_not_venue')) {
	function user_is_not_venue($user) {

		return !user_is_venue($user);
	}
}