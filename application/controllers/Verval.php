<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Verval extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('PengajuanModel', 'model');
		// $this->load->model('Auth_model');

		// $user = $this->Auth_model->current_user();
		// if (!$this->Auth_model->current_user() || $user->level != 'admin' && $user->level != 'bunda') {
		// 	redirect('login/logout');
		// }
	}

	public function index()
	{
		$data['judul'] = 'verval';
		$data['data'] = $this->model->verval()->result();
		// $data['user'] = $this->Auth_model->current_user();

		$this->load->view('head', $data);
		$this->load->view('verval', $data);
		$this->load->view('foot');
	}

	public function setujui($kode)
	{
		$data = ['status' => 'disetujui'];
		$this->model->edit('pengajuan', $data, $kode);
		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata('ok', 'Pengajuan Disetujui. Silahkan menghubungi admin pencairan untuk pencairan pengajuan!');
			redirect('verval');
		} else {
			$this->session->set_flashdata('error', 'Persetujuan Data Gagal');
			redirect('verval');
		}
	}

	public function tolak($kode)
	{
		$data = ['status' => 'ditolak'];
		$this->model->edit('pengajuan', $data, $kode);
		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata('ok', 'Pengajuan Ditolak');
			redirect('verval');
		} else {
			$this->session->set_flashdata('error', 'Persetujuan Data Gagal');
			redirect('verval');
		}
	}
}
