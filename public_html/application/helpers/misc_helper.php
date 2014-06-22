<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
*
*	misc_helper
*
*	A helper without borders.
*
**/
if (!function_exists('event_date_format')) {

	function event_date_format($date, $lang = 'en') {
		if ($lang == 'en') {
			return date('l, F jS', strtotime($date));
		} else {
			//translate
			$french_days = array(
				'Monday' => 'lundi',
				'Tuesday' => 'mardi',
				'Wednesday' => 'mercredi',
				'Thursday' => 'jeudi',
				'Friday' => 'vendredi',
				'Saturday' => 'samedi',
				'Sunday' => 'dimanche',
			);

			$french_months = array(
				'January' => 'janvier',
				'February' => 'février',
				'March' => 'mars',
				'April' => 'avril',
				'May' => 'mai',
				'June' => 'juin',
				'July' => 'juillet',
				'August' => 'août',
				'September' => 'septembre',
				'October' => 'octobre',
				'November' => 'novembre',
				'December' => 'décembre',
			);

			$ts = strtotime($date);

			return $french_days[date('l', $ts)].', '.date('j', $ts).' '.$french_months[date('F', $ts)];
		}
	}
}