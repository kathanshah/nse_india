<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model("nseapi");
	}
	
	public function index(){
		$this->load->view("home/header");
		$this->load->view("home/home");
	}

	public function getData(){
		$input = $this->input->get(['from','to']);
		if ($input['from'] && $input['to']){
			$data=$this->nseapi->getTrending($input);

			$this->output
				->set_content_type('application/json')
				->set_status_header(200)
				->set_output(json_encode($data));
		}
		else{
			$this->output
				->set_content_type('application/json')
				->set_status_header(404);
		}
	}
}