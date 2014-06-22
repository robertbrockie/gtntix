<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
*
*	event_helper
*
*	Helper for events
*
**/
if (!function_exists('build_event_string')) {

	function build_event_string($events, $event_id, $lang = 'en', $class = '') {

		// make sure we have some events
		if (empty($events)) {
			return '';
		}

		$string = '<a href="'.translate_route('event/view', $lang).'/'.$event_id.'">';
		$i = 0;

		foreach($events as $event) {
			if ($i > 0) {
				$string .= ' + ';
			}

			$string .= '<span class="bold '.$class.'">'.$event->name.'</span>';
			$i++;
		}

		$string .= '</a>';

		return $string;
	}
}

if (!function_exists('build_event_image')) {

	function build_event_image($event, $lang, $image_prefix) {
		return '<a href="'.translate_route('event/view', $lang).'/'.$event->id.'"><img src="'.$image_prefix.$event->image_url.'" /></a>';
	}
}