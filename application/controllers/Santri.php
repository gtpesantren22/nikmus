<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Santri extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('SantriModel', 'model');
		$this->load->model('Auth_model');

		$user = $this->Auth_model->current_user();
		if (!$this->Auth_model->current_user()) {
			redirect('login/logout');
		}
	}

	public function index()
	{
		$data['judul'] = 'santri';
		$data['baru'] = $this->model->baru()->result();
		$data['user'] = $this->Auth_model->current_user();

		$this->load->view('head', $data);
		$this->load->view('santri', $data);
		$this->load->view('foot');
	}

	public function sync()
	{
		$result = $this->model->syncSantri();
		if ($result !== false && $result > 0) {
			$this->session->set_flashdata('ok', 'Sinkronisasi berhasil! ' . number_format($result, 0, ',', '.') . ' data santri berhasil diperbarui dari Database Sentral.');
		} elseif ($result === 0) {
			$this->session->set_flashdata('ok', 'Sinkronisasi selesai. Tidak ada data santri aktif ditemukan di Database Sentral.');
		} else {
			$this->session->set_flashdata('error', 'Gagal melakukan sinkronisasi data santri dari Database Sentral. Silakan periksa koneksi.');
		}
		redirect('santri');
	}
}