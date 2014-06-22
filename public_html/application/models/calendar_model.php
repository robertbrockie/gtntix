<?php 

class Calendar_model extends CI_Model {

	var $conf;
	var $language;

	function __construct() {
		parent::__construct();

		$this->language = $this->config->item('website_lang');

		$this->load->model('event_model');
		$this->load->model('eventartist_model');

		$this->conf =  array(
			'show_next_prev' => true,
			'next_prev_url' => translate_route('event/calendar', $this->language),
			'month_type' => 'long',
			'day_type' => 'short,'
		);

		$this->conf['template'] = '
			{table_open}<table border="0" cellpadding="0" cellspacing="0" class="calendar">{/table_open}
			
			{heading_row_start}<tr>{/heading_row_start}

			{heading_previous_cell}<th><a href="{previous_url}">&lt;&lt;</a></th>{/heading_previous_cell}
			{heading_title_cell}<th colspan="{colspan}">{heading}</th>{/heading_title_cell}
			{heading_next_cell}<th><a href="{next_url}">&gt;&gt;</a></th>{/heading_next_cell}

			{heading_row_end}</tr>{/heading_row_end}

			{week_row_start}<tr>{/week_row_start}
			{week_day_cell}<td>{week_day}</td>{/week_day_cell}
			{week_row_end}</tr>{/week_row_end}

			{cal_row_start}<tr class="days">{/cal_row_start}
			{cal_cell_start}<td>{/cal_cell_start}

			{cal_cell_content}
				<div class="day_num">{day}</div>
				<div class="content">{content}</div>
			{/cal_cell_content}
			{cal_cell_content_today}
				<div class="day_num highlight">{day}</div>
				<div class="content">{content}</div>
			{/cal_cell_content_today}

			{cal_cell_no_content}
				<div class="day_num">{day}</div>
			{/cal_cell_no_content}
			{cal_cell_no_content_today}
				<div class="day_num highlight">{day}</div>
			{/cal_cell_no_content_today}

			{cal_cell_blank}&nbsp;{/cal_cell_blank}

			{cal_cell_end}</td>{/cal_cell_end}
			{cal_row_end}</tr>{/cal_row_end}

			{table_close}</table>{/table_close}
		';
	}

	function getEventData($year = null, $month = null) {

		if (!$year) {
			$year = date('Y');
		}

		if (!$month) {
			$month = date('m');
		}

		// get the events for the month
		$events = $this->event_model->getMonthEvents($year, $month);

		// get the artists for the events and build the calendar data
		$event_artists = array();
		$calendar_data = array();
		foreach ($events as $event) {
			$event_artists[$event->id] = $this->eventartist_model->getArtistsForEventId($event->id);

			//build the content

			// the index of the calander data should be the date number
			$index = (int) substr($event->date, 8, 2);

			// get the artist name
			if (count($event_artists[$event->id])) {
				//Take the first artist
				$artist_name = $event_artists[$event->id][0]->name;
			} else {
				// No artist to display
				continue;
			}

			$calendar_data[$index][] = '<a href="'.translate_route('event/view', $this->language).'/'.$event->id.'">'.$artist_name.' - '.$event->venue_name.'</a>';
		}

		return $calendar_data;
	}

	function generate($year = null, $month = null) {

		switch ($this->language) {
			case 'fr':
				$this->lang->load('calendar', 'french');
				$this->load->library('parser');
				break;
		}

		$this->load->library('calendar', $this->conf);

		return $this->calendar->generate($year, $month, $this->getEventData($year, $month));
	}

}

?>