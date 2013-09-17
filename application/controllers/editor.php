<?php

class Editor extends CI_Controller {
	function __construct() {
		parent::__construct();
	}

	function demo() {
		$data['title'] = "Test Editor";
		$this->load->view("editor/demo", $data);
	}
}

?>
