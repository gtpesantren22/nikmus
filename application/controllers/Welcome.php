<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Auth_model');
		$this->tahun = $this->session->userdata('tahun');
		$this->db2 = $this->load->database('sentral', true);

		// $user = $this->Auth_model->current_user();
		if (!$this->Auth_model->current_user()) {
			redirect('login/logout');
		}
	}

	public function index()
	{
		$data['judul'] = 'index';
		$data['tahun'] = $this->tahun;
		$data['user'] = $this->Auth_model->current_user();
		$data['pakai'] = $this->Auth_model->pakai($this->tahun)->row();
		$data['pagu'] = $this->db2->query("SELECT * FROM pagu WHERE nama = 'NIKMUS' AND tahun =  '$this->tahun' ")->row();
		$lembaga = $data['user']->lembaga;
		$data['jumlah'] = $this->db->query("SELECT COUNT(kode_pengajuan) as jumlah FROM pengajuan WHERE tahun =  '$this->tahun' AND lembaga = '$lembaga' ")->row('jumlah');
		$data['total'] = $this->db->query("SELECT SUM(nom_kriteria+transport+sopir) as total FROM pengajuan WHERE tahun =  '$this->tahun' AND lembaga = '$lembaga' ")->row('total');

		$this->load->view('head', $data);
		$this->load->view('index');
		$this->load->view('foot');
	}
}
