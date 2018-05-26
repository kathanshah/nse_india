<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model("nseapi");
	}
	
	public function index(){

		$data['result']=$this->nseapi->getTrending();

		$this->load->view("home/header",$data);
		$this->load->view("home/home");
	}

	public function getData(){
		/* $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($response)); */
	}
}