<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
		$data['judul'] = 'index';

		$this->load->view('head', $data);
		$this->load->view('index');
		$this->load->view('foot');
	}
}
