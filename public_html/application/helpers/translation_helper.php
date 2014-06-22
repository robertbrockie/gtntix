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
			'company_name' => array(
							'en' => 'GTNTix',
							'fr' => 'ReseauGTN',
						),
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
			'title' => array(
							'en' => 'GTNtix - Tickets the easy way!',
							'fr' => 'ReseauGTN - Billets en toute simplicité!',
						),
			'web_design' => array(
							'en' => 'Web Design',
							'fr' => 'Conception Web',
						),
			'web_development' => array(
							'en' => 'Web Development',
							'fr' => 'Développement Web',
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