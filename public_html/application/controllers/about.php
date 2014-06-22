<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class About extends MY_Controller {

	public function index() {
		$data = $this->initializeData();

		$data['header'] = 'about';

		$this->renderView('about', $data);
	}
}