<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pencairan extends CI_Controller
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
		$data['judul'] = 'cair';
		$data['data'] = $this->model->cair()->result();
		// $data['user'] = $this->Auth_model->current_user();

		$this->load->view('head', $data);
		$this->load->view('cair', $data);
		$this->load->view('foot');
	}

	public function cek($kode)
	{
		$data['judul'] = 'cair';
		$data['data'] = $this->model->getBy('pengajuan', 'kode_pengajuan', $kode)->row();
		// $data['user'] = $this->Auth_model->current_user();

		$this->load->view('head', $data);
		$this->load->view('cek', $data);
		$this->load->view('foot');
	}

	public function saveAdd()
	{
		$kode = $this->input->post('kode_pengajuan', true);
		$data = ['status' => 'selesai'];
		$data2 = [
			'kode_pengajuan' => $kode,
			'penerima' => $this->input->post('penerima', true),
			'nom_cair' => rmRp($this->input->post('nominal', true)),
			'tgl_cair' => $this->input->post('tgl_cair', true),
			'kasir' => $this->input->post('kasir', true)
		];
		$data3 = [
			'kode_pengajuan' => $kode,
			'status' => 'belum',
			'tahun' => '2022/2023'
		];
		$this->model->edit('pengajuan', $data, $kode);
		$this->model->simpan('pencairan', $data2);
		$this->model->simpan('spj', $data3);
		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata('ok', 'Pengajuan sudah dicairkan.');
			redirect('pencairan');
		} else {
			$this->session->set_flashdata('error', 'Pencairan Gagal');
			redirect('pencairan');
		}
	}
}