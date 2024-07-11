<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pencairan extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('PengajuanModel', 'model');
		$this->load->model('Auth_model');
		$this->tahun = $this->session->userdata('tahun');

		$user = $this->Auth_model->current_user();
		if (!$this->Auth_model->current_user()) {
			redirect('login/logout');
		} elseif ($user->level != 'account' && $user->level != 'kasir') {
			echo "
            <script>
            alert('Maaf. Data tidak dapat megakses halaman ini');
            window.location = '" . base_url('welcome') . "';
            </script>
            ";
		}
	}

	public function index()
	{
		$data['judul'] = 'cair';
		$data['data'] = $this->model->cair()->result();
		$data['user'] = $this->Auth_model->current_user();
		$data['tahun'] = $this->tahun;

		$this->load->view('head', $data);
		$this->load->view('cair', $data);
		$this->load->view('foot');
	}

	public function cek($kode)
	{
		$data['judul'] = 'cair';
		$data['data'] = $this->model->getBy('pengajuan', 'kode_pengajuan', $kode)->row();
		$data['daerah'] = $this->model->getBy('transport', 'kode_transport', $data['data']->daerah)->row();
		$data['user'] = $this->Auth_model->current_user();
		$data['tahun'] = $this->tahun;

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
			'tahun' => $this->tahun
		];
		$data4 = [
			'kode_pengajuan' => $kode,
			'status' => 'Pencairan',
			'ket' => 'Pencairan Pengajuan Nikmus',
			'oleh' => 'Admin Pencairan',
			'at' => date('Y-m-d H:i')
		];

		$key = $this->model->getBy('api', 'nama', 'Bendahara')->row();
		$dtpj = $this->model->getBy('pengajuan', 'kode_pengajuan', $kode)->row();
		$daerah = $this->model->getBy('transport', 'kode_transport', $dtpj->daerah)->row();
		$pesan = '*INFORMASI PENCAIRAN NIKMUS*
Pengajuan Baru 

Kode : ' . $dtpj->kode_pengajuan . '
Nama : ' . $dtpj->nama . '
Kriteria : ' . $dtpj->kriteria . '
Daerah : ' . $daerah->daerah . '
Nominal : *' . rupiah($dtpj->nom_kriteria + $dtpj->sopir + $dtpj->transport) . '*
Penerima : *' . $this->input->post('penerima', true) . '*

Terimakasih';

		$this->model->edit('pengajuan', $data, $kode);
		$this->model->simpan('pencairan', $data2);
		$this->model->simpan('spj', $data3);
		$this->model->simpan('history', $data4);
		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata('ok', 'Pengajuan sudah dicairkan.');
			kirim_person($key->nama_key, '085234223306', $pesan);
			kirim_person($key->nama_key, '085236924510', $pesan);
			redirect('pencairan');
		} else {
			$this->session->set_flashdata('error', 'Pencairan Gagal');
			redirect('pencairan');
		}
	}
}
