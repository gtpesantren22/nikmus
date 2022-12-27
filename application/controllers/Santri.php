<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Santri extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('SantriModel', 'model');
		// $this->load->model('Auth_model');

		// $user = $this->Auth_model->current_user();
		// if (!$this->Auth_model->current_user() || $user->level != 'admin' && $user->level != 'bunda') {
		// 	redirect('login/logout');
		// }
	}

	public function index()
	{
		$data['judul'] = 'santri';
		$data['baru'] = $this->model->baru()->result();
		// $data['user'] = $this->Auth_model->current_user();

		$this->load->view('head', $data);
		$this->load->view('santri', $data);
		$this->load->view('foot');
	}

	// public function lanjut()
	// {
	// 	$data['baru'] = $this->model->lama()->result();
	// 	$data['judul'] = 'santri';
	// 	$data['user'] = $this->Auth_model->current_user();

	// 	$this->load->view('bunda/head', $data);
	// 	$this->load->view('bunda/lama', $data);
	// 	$this->load->view('bunda/foot');
	// }
}