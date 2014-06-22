<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
*
*	router_translation_helper
*
*	Helping with translating urls.
*
**/
if (!function_exists('translate_route')) {

	function translate_route($route, $lang) {

		$routes = array(
			'about' => array(
							'en' => 'about',
							'fr' => 'apropos',
						),
			'event' => array(
							'en' => 'event',
							'fr' => 'evenements',
						),
			'event/calendar' => array(
							'en' => 'event/calendar',
							'fr' => 'evenements/calendrier',
						),
			'event/view' => array(
							'en' => 'event/view',
							'fr' => 'evenements/consulter',
						),
			'event/search' => array(
							'en' => 'event/search',
							'fr' => 'evenements/recherche',
						),
			'venue/events' => array(
							'en' => 'venue/events',
							'fr' => 'salle/evenements',
						),
		);

		if (isset($routes[$route][$lang])) {
			return base_url().$routes[$route][$lang];
		} else {
			error_log('Could not translate route: '.$route.' for lang: '.$lang);
			return base_url().$route;
		}
	}
}