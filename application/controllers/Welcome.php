<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Auth_model');

		// $user = $this->Auth_model->current_user();
		if (!$this->Auth_model->current_user()) {
			redirect('login/logout');
		}
	}

	public function index()
	{
		$data['judul'] = 'index';
		$data['user'] = $this->Auth_model->current_user();
		$data['pakai'] = $this->Auth_model->pakai()->row();

		$this->load->view('head', $data);
		$this->load->view('index');
		$this->load->view('foot');
	}
}