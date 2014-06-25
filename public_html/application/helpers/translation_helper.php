<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
*	translation_helper
*
*	Need help translating something.
*
**/

/**
*	translate_word
*
*	@param key - The key the represents the word we want to translate.
*	@param lang - The language we wish to translate.
*
*	@return A word translated into the specific language.
**/
if (!function_exists('translate_word')) {

	function translate_word($key, $lang) {

		$words = array(
			'about' => array(
							'en' => 'About',
							'fr' => 'À Propos',
						),
			'calendar' => array(
							'en' => 'Calendar',
							'fr' => 'Calendrier',
						),
			'company_name' => array(
							'en' => 'GTNTix',
							'fr' => 'ReseauGTN',
						),
			'doors' => array(
							'en' => 'Doors',
							'fr' => 'Portes'
						),
			'event_calendar' => array(
							'en' => 'Event Calendar',
							'fr' => 'Calendrier des Événements',
						),
			'home' => array(
							'en' => 'Home',
							'fr' => 'Accueil',
						),
			'no_event' => array(
							'en' => 'No event found!',
							'fr' => 'Rien Trouver!',
						),
			'purchase_tickets' => array(
							'en' => 'Purchase Tickets',
							'fr' => 'Achat de billets'
						),
			'search' => array(
							'en' => 'Search',
							'fr' => 'Recherche'
						),
			'search_results' => array(
							'en' => 'Search Results',
							'fr' => 'Résultats de la recherche',
						),
			'slogan' => array(
							'en' => 'Tickets the easy way!',
							'fr' => 'Billets en toute simplicité!'
						),
			'show' => array(
							'en' => 'Show',
							'fr' => 'Spectacle'
						),
			'tickets' => array(
							'en' => 'Tickets',
							'fr' => 'Achat de billets',
						),
			'title' => array(
							'en' => 'GTNtix - Tickets the easy way!',
							'fr' => 'ReseauGTN - Billets en toute simplicité!',
						),
			'upcoming_events' => array(
							'en' => 'Upcoming Events',
							'fr' => 'Événements',
						),
			'venues' => array(
							'en' => 'Venues',
							'fr' => 'Salles',
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

/**
*	translate_event_field
*
*	@param event - The event
*	@param field - The field of the event we want to translate.
*	@param lang - The language we wish to translate.
*
*	@return A field translated into the specific language.
**/
if (!function_exists('translate_event_field')) {

	function translate_event_field($event, $field, $lang) {

		switch ($field) {
			case 'ticket_url':
				if ($lang == 'en') {
					return $event->ticket_url_en;
				} else {
					return $event->ticket_url_fr;
				}
				break;
			case 'ticket_description':
				if ($lang == 'en') {
					return $event->ticket_description_en;
				} else {
					return $event->ticket_description_fr;
				}
				break;
			default:
				error_log('Could not find event field: '.$field);
				return '';
		}
	}
}

/**
*	translate_artist_field
*
*	@param artist - The artist
*	@param field - The field of the artist we want to translate.
*	@param lang - The language we wish to translate.
*
*	@return A field translated into the specific language.
**/
if (!function_exists('translate_artist_field')) {

	function translate_artist_field($artist, $field, $lang) {

		switch ($field) {
			case 'bio':
				if ($lang == 'en') {
					return $artist->bio_en;
				} else {
					return $artist->bio_fr;
				}
				break;
			default:
				error_log('Could not find artist field: '.$field);
				return '';
		}
	}
}
