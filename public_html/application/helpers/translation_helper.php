<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
*
*	translation_helper
*
*	Helping with translating words.
*
**/
if (!function_exists('translate_word')) {

	function translate_word($key, $lang) {

		$words = array(
			'upcoming_events' => array(
							'en' => 'Upcoming Events',
							'fr' => 'Événements',
						),
			'event_calendar' => array(
							'en' => 'Event Calendar',
							'fr' => 'Calendrier des Événements',
						),
			'search_results' => array(
							'en' => 'Search Results',
							'fr' => 'Résultats de la recherche',
						),
		);

		if (isset($words[$key][$lang])) {
			return $words[$key][$lang];
		} else {
			error_log('Could not translate word: '.$key.' for lang: '.$lang);
			return '';
		}
	}
}